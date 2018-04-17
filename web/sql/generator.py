import sys;
import logging;
import pymysql; #mysql library (you will need to install this on the system)
import getopt

#ALTER DATABASE DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci 
class MySQLConnector(object):

    _connection = None;
    _instance = None;
    _log = None;
 
    def __init__(self, host="127.0.0.1", user="", passwd="", database="", debug=False):    # Versi�n 1.0.1
        self._log = logging.getLogger('MySQLConnector')
        try:
            ##if MySQLConnector._instance == None:
            ##    MySQLConnector._instance = self;
                self.dbhost = host
                self.dbuser = user
                self.dbpassword = passwd
              
                self.dbname = database
            ## MySQLConnector._instance.connect(debug);
                self.connect(debug);

        except Exception as e :
            self._log.error ("MySQL Error "+str(e));
 
    def instance(self):
    ##    return MySQLConnector._instance;
        return self;
 
    def get_connection(self):
    ##    return MySQLConnector._connection;
        return self._connection;
 
    def connect(self, debug=False):
        try:
            ##MySQLConnector._connection = pymysql.connect(self.dbhost, self.dbuser, self.dbpassword, self.dbname);
            self._connection = pymysql.connect(self.dbhost, self.dbuser, self.dbpassword, self.dbname);
            if debug:
                self._log.info("Database connection successfully established")
        except Exception as e:
            self._log.error ("MySQL Connection Couldn't be created... Fatal Error! "+str(e))
            sys.exit()
 
    def disconnect(self):
        try:
            ## MySQLConnector._connection.close();
            self._connection.close();
        except:
            pass;#connection not open
 
    #query with no result returned
    def query(self, sql):
        cur = self._connection.cursor();
        return cur.execute(sql);
 
    def tryquery(self, sql):
        try:
            cur = self._connection.cursor();
            return cur.execute(sql);
        except:
            return False;
 
    #inserts and returns the inserted row id (last row id in PHP version)
    def insert(self, sql):
        cur = self._connection.cursor();
        cur.execute(sql);
        return self._connection.insert_id();
 
    def tryinsert(self, sql):
        try:
            cur = self._connection.cursor();
            cur.execute(sql);
            return self._connection.insert_id();
        except:
            return -1;
 
    #returns the first item of data
    def queryrow(self, sql):
        cur = self._connection.cursor();
        cur.execute(sql);
        return cur.fetchone();
 
    #returns a list of data (array)
    def queryrows(self, sql):
        cur = self._connection.cursor();
        cur.execute(sql);
        return cur.fetchmany();

    def queryallrows(self, sql):
        cur = self._connection.cursor();
        cur.execute(sql);
        return cur.fetchall();




import configparser
import os.path

Config = configparser.ConfigParser()

filename = './configuration.ini'
filename_dist = filename + '.dist'

if os.path.isfile(filename_dist ):
    Config.read(filename_dist )
else:
    Config.read(filename )


# coding: utf-8
__author__ = 'gcailley'

config_database_origine = {}
config_database_origine['host'] = Config.get('config_database_origine',  'host')
config_database_origine['user'] = Config.get('config_database_origine', 'user')
config_database_origine['passwd'] = Config.get('config_database_origine', 'passwd')
config_database_origine['database'] = Config.get('config_database_origine', 'database')
config_database_origine['debug'] = Config.get('config_database_origine', 'debug')

config_database_cible = {}
config_database_cible['host'] = Config.get('config_database_cible',  'host')
config_database_cible['user'] = Config.get('config_database_cible', 'user')
config_database_cible['passwd'] = Config.get('config_database_cible', 'passwd')
config_database_cible['database'] = Config.get('config_database_cible', 'database')
config_database_cible['debug'] = Config.get('config_database_cible', 'debug')


DELETE_ALL = 'TRUNCATE {}'
SELECT = 'SELECT {} from {}'
INSERT = 'INSERT INTO {} ({}) VALUES {};'


if __name__ == "__main__":
    log = logging.getLogger('Main')
    _debug=False;

    try:                                
        opts, args = getopt.getopt(sys.argv[1:], "h:d", ["help", "grammar="])
    except getopt.GetoptError:          
        usage()                         
        sys.exit(2)                     
    for opt, arg in opts:
        if opt in ("-h", "--help"):
            usage()                     
            sys.exit()                  
        elif opt == '-d':
            _debug=True;
            log.warn('Debug mode : [ON]');
            logging.basicConfig(level=logging.DEBUG)

    if (_debug != True):
        log.warn('Debug mode : [OFF]');
        logging.basicConfig(level=logging.INFO)

    log.debug(str.format('Connecting to {}', config_database_origine['database']))
    mysqlOrigine = MySQLConnector(**config_database_origine)
    log.info('Connecting to ' +  config_database_origine['database'] + ': [DONE]')

    log.debug(str.format('Connecting to {}', config_database_cible['database']))
    mysqlCible = MySQLConnector(**config_database_cible)
    log.info('Connecting to ' +  config_database_cible['database'] + ': [DONE]')

    # execution du fichier de suppression des tables.
    log.info(str.format(' -- TRUNCATE TABLES -- '));
    mysqlCible.query("SET FOREIGN_KEY_CHECKS=0;");
    for section in Config.sections():
        log.info(str.format('\t > {}',  section));
        if (not Config.get(section,'table_cible', fallback=False) ):
            log.warning(str.format('Skipping section : {} ', section));
            continue;
        table_cible = Config.get(section,'table_cible')
        log.info(str.format('Deleting table : {}', table_cible));
        delete_cible = str.format(DELETE_ALL, table_cible)
        log.info(str.format('Deleting  : {}', delete_cible));
        mysqlCible.query(delete_cible);

    mysqlCible.query("SET FOREIGN_KEY_CHECKS=1;");
    mysqlCible.query("COMMIT;");
    
    nb_insert = 0;
    nb_error = 0;

    log.info(str.format(' -- PROCESSING TABLE -- '));    
    for section in Config.sections():
        error_section = 0
        log.info(str.format('\t > {}', section));
        mysqlCible.query("SET FOREIGN_KEY_CHECKS=0;");
        mysqlCible.query("SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO';");

        if (not Config.get(section,'table_origine', fallback=False) or not Config.get(section,'table_cible', fallback=False) ):
            log.warning(str.format('Skipping section : {} ', section));
            continue;

        table_origine = Config.get(section,'table_origine')
        fields_origine = Config.get(section,'fields_origine')
        table_cible = Config.get(section,'table_cible')
        fields_cible = Config.get(section,'fields_cible')

        log.info(str.format('Processing table : {} > {}', table_origine, table_cible));

        # generate SELECT on origine table
        select_origine = str.format(SELECT , fields_origine, table_origine );
        try:
            where_origine = Config.get(section, 'select_where_origine')
            select_origine = str.format('{} WHERE {}', select_origine, where_origine);
            log.error(select_origine);
        except Exception as e:
            log.warning('No WHERE conditions to apply.');

        select_origine = select_origine.replace('[format]',"'%Y-%m-%d'");
        select_origine = select_origine.replace('[*]',"%");
        log.info(str.format('Selecting : {}', select_origine));
        rows = mysqlOrigine.queryallrows(select_origine);

        log.debug(str.format('Inserting : {}', len(rows)));
        for row in rows:
            insert_cible = str.format(INSERT, table_cible, fields_cible, row );
            try: 
                mysqlCible.insert(insert_cible);
                log.debug(str.format('Inserting : {} [OK]', insert_cible));
                nb_insert += 1
            except Exception as e :
                nb_error += 1
                error_section += 1
                log.debug(str.format('Inserting : {} [KO]', insert_cible));
                log.debug(str.format('Error message : {}', str(e)));

        mysqlCible.query("SET FOREIGN_KEY_CHECKS=1;");
        mysqlCible.query("COMMIT;");

        select_cible = str.format(SELECT , fields_cible, table_cible );
        rowsAfter = mysqlCible.queryallrows(select_cible);
    
        
        if (error_section != 0) :
            log.error(str.format('Failure for table {} ({}).',table_cible, error_section));
            log.error(str.format('Select for origine table {}.',select_origine));
            if(input(str.format("Next table ? [n] to exit \n {} errors >",nb_error)) == 'n'):
                sys.exit(0);
        else :
            log.info(str.format('Success for table {} ({}/{}).',table_cible, len(rows),  len(rowsAfter)));

    mysqlOrigine.disconnect();
    mysqlCible.disconnect();

    log.info(str.format('\nBilan Insert:{} Error:{}', nb_insert,  nb_error));