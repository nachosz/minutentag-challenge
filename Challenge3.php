<?php
class DateViewer {
    const SOURCE_SITE = "http://date.jsontest.com/";
    const FORMAT_STRING = "l jS \of F, Y - h:i A";

    public function displayData()
    {
        $data = $this->fetchData();
        return $this->formatData($data);
    }

    private  function fetchData() : stdClass
    {
        $data = @file_get_contents(self::SOURCE_SITE);
        if($data === false){
            throw new Exception("Cannot access site. Try again later.");
        }

        return json_decode($data);
    }

    private function formatData(stdClass $data, $formatString = self::FORMAT_STRING) : string
    {
        return date($formatString, $data->milliseconds_since_epoch/1000);
    }
}

$dv = new DateViewer();
echo $dv->displayData();