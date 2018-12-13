<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 30.10.18
 * Time: 10:24
 */

namespace Phore\StatusPage\Tpl;


use Phore\Html\Elements\HtmlElementNode;
use Phore\Html\Elements\RawHtmlNode;
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

    
    public function a(string $href, $body)
    {
        return fhtml(["a @href=:href" => $body], ["href" => $href]);
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


    public function modal(string $id, $title, $body, $footer=null)
    {
        $root = fhtml("div @modal @fade @id=:id @role=dialog", ["id" => $id]);
        $inside = $root["@modal-dialog @role=document {$this->_getWith()}"]["@modal-content"];

        $header = $inside["@modal-header"];
        if($title !== null) {
            if (is_string($title))
                $header["h5 @modal-title"] = $title;
            else
                $header[] = $title;
        }
        $header["button @type=button @close @data-dismiss=modal @aria-label=close"]["span @aria-hidden=true"] = new RawHtmlNode("&times;");

        $fbody = $inside["@modal-body"];
        $fbody[] = $body;

        if ($footer !== null) {
            $inside["@modal-footer"] = $footer;

        }
        return $root;
    }

    public function modal_open_button($id, $text)
    {
        return fhtml(["button @type=button @btn @btn-primary @data-toggle=modal @data-target=#$id" => $text]);
    }



    public function view_code($code)
    {
        $md = md5($code);
        $this->nextWith = "@style=width:90% @modal-lg";
        return [
            $this->modal($md, "View Code", ["pre" => ["code @php" => $code]]),
            ["@container @text-center @" => $this->modal_open_button($md, ["i @fas @fa-code" => null, " view source"])]
        ];
    }


    
    public function alert($content)
    {
        if ($content instanceof \Exception) {
            $content = [
                "b" => $content->getMessage(),
            ];
        }
        return fhtml(["div @alert @alert-danger @role=alert" => $content]);
    }

    
    public function basic_table (array $header, array $data, array $cssTdClasses=[])
    {
        $table = fhtml("table @table {$this->_getWith()}");
        $cols = [];
        if ($header !== null) {
            $head = $table["thead"]["tr"];
            foreach ($header as $idx => $name) {
                $css = "";
                if (isset($cssTdClasses[$idx]))
                    $css = $cssTdClasses[$idx];
                $head[] = fhtml(["th $css" => $name]);
            }
        }
        $tBody = $table["tbody"];
        
        foreach ($data as $rowData) {
            $tr = fhtml("tr");
            foreach ($rowData as $idx => $tdData) {
                if (isset ($cssTdClasses[$idx])) {
                    $tr["td {$cssTdClasses[$idx]}"] = $tdData;
                } else {
                    $tr["td"] = $tdData;
                }
            }
            $tBody[] = $tr;
        }
        return $table;
    }
    

    public function table(array $data, $header=null, callable $rowRenderer = null, $colRenderer=[])
    {
        $table = fhtml("table @table {$this->_getWith()}");
        $cols = [];
        if ($header !== null) {
            $head = $table["thead"]["tr"];
            foreach ($header as $key => $value) {
                $head[] = fhtml(["th" => $value]);
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
                if ($tdData instanceof HtmlElementNode) {
                    $tr["td"] = $tdData;
                    continue;
                }
                if (is_array($tdData)) {
                    $tr["td"] = $tdData;
                    continue;
                }
                if (isset ($colRenderer[$colName]) && is_callable($colRenderer[$colName])) {
                    $tr["td"] = ($colRenderer[$colName])($tdData, $rowData, $colName);
                    continue;
                }


                $tr["td"] = (string)$tdData;
            }

            if ($rowRenderer !== null)
                $tr = $rowRenderer($tr, $rowData);
            $tBody[] = $tr;

        }
        return $table;
    }


}
