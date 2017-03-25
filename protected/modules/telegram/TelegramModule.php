<?php

class TelegramModule extends DaWebModuleAbstract
{

    public function init()
    {
        $this->setImport(array(
            $this->id . '.models.*',
            $this->id . '.controllers.*',
            $this->id . '.components.*',
            $this->id . '.commands.*',
        ));
    }
}
