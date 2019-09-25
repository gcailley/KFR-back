<?php

namespace App\Controller\Api;

interface IApiController {

    function newTypeClass() : string;
    function newDtoClass(): string;
    function newBuilderClass(): string;
    function newModeleClass(): string;

}
