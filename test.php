<?php

class Test
{
    public function __call($name, $arguments) {
        var_dump(__METHOD__);
    }
}

//$test = new Test;
//$test->go();

var_dump(explode('new_', 'new_alias')[1]);