<?php

namespace App\Form\Dto\Kungfu;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqKungfuTaoProfDTO extends RtlqKungfuTaoDTO {


    protected $video_url;
    public function setVideoUrl($value)
    {
        $this->video_url = $value;
        return $this;
    }

    public  function getVideoUrl() {
        return $this->video_url;
    }
}
