<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 30.10.18
 * Time: 10:24
 */

namespace Phore\StatusPage\Tpl;


use Phore\Html\Elements\TextNode;

class Elements
{
    private $nextWith = "";

    public function __construct($optStyles = "")
    {
        $this->nextWith = $optStyles;
    }



    private function _getWith() : string
    {
        $with = $this->nextWith;
        $this->nextWith = "";
        return $with;
    }

    public function card($header=null, $body=null, $footer=null)
    {
        return [
            "@card {$this->_getWith()}" => function () use ($header, $body, $footer) {
                $ret = [];

                if ($header !== null)
                    $ret["@card-header"] = $header;
                if ($body !== null)
                    $ret["@card-body"] = $body;
                if ($footer !== null)
                    $ret["@card-footer"] = $footer;
                return $ret;
            }
        ];
    }



    public function table(array $data, $header=null, callable $rowRenderer = null, $colRenderer=[])
    {
        $table = fhtml("table @table {$this->_getWith()}");
        $cols = [];
        if ($header !== null) {
            $head = $table["thead"]["tr"];
            foreach ($header as $key => $value) {
                $head[] = fhtml("th")->content($value);
                $cols[] = $key;
            }
        }

        $tBody = $table["tbody"];

        foreach ($data as $rowData) {
            $tr = fhtml("tr");

            if (count ($cols) === 0) {
                $cols = array_keys($rowData);
            }

            foreach ($cols as $colName) {
                $tdData = isset ($rowData[$colName]) ? $rowData[$colName] : null;
                if (isset ($colRenderer[$colName]) && is_callable($colRenderer[$colName])) {
                    $tr["td"] = ($colRenderer[$colName])($tdData, $rowData, $colName);
                    continue;
                }
                $tr["td"]->text((string)$tdData);
            }

            if ($rowRenderer !== null)
                $tr = $rowRenderer($tr, $rowData);
            $tBody[] = $tr;

        }
        return $table;
    }


}