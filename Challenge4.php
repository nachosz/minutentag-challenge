<?php
class AnswerViewer {
    const SOURCE_SITE = "http://echo.jsontest.com/john/yes/tomas/no/belen/yes/peter/no/julie/no/gabriela/no/messi/no";
    const FORMAT_DATA = "|%-5.5s |%-5.5s |\n";
    public function displayData()
    {
        $data = $this->fetchData();

        return $this->formatData($data);
    }

    private  function fetchData() : array
    {
        $data = @file_get_contents(self::SOURCE_SITE);
        if($data === false){
            throw new Exception("Cannot access site. Try again later.");
        }

        return json_decode($data, true);
    }

    private function formatData(array $data, $formatString = self::FORMAT_DATA)
    {
        $columns = [
            "No" => [],
            "Yes" => []
        ];
        $orderedData = $this->orderDataInColumns($data, $columns);

        //Print and format
        printf($formatString, array_keys($columns)[0],  array_keys($columns)[1]);
        $maxLoop = max(count($orderedData['Yes']), count($orderedData['No']));
        for($i = 0; $i < $maxLoop ; $i++){
            printf($formatString,isset($orderedData["No"][$i]) ? $orderedData["No"][$i] : '', isset($orderedData["Yes"][$i]) ? $orderedData["Yes"][$i] : '');
        }

    }

    private function orderDataInColumns(array $data, $columns)
    {

        foreach ($data as $key => $value){
            if($value == 'no'){
                $columns["No"][] = $key;
            }
            else{
                $columns["Yes"][] = $key;
            }
        }
        return $columns;
    }
}

$dv = new AnswerViewer();
echo $dv->displayData();