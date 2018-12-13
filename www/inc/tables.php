<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 30.10.18
 * Time: 14:03
 */

namespace App;

use Phore\Html\Fhtml\FHtml;
use Phore\Html\Helper\Highlighter;
use Phore\Html\Helper\Table;

$h = new Highlighter();

$doc = fhtml();

$tableData = [
    ["col1" => "Column 1 Data", "col2" => "Column 2 Data"],
    ["col1" => "Col 1 Row 2 Data", "col2" => "Col 2 Row 2 Data"],
    ["col1" => "Col 1 Row 3 Data", "col2" => "Col 2 Row 3 Data"],
    ["col1" => "Col 1 Row 4 Data", "col2" => "Col 2 Row 4 Data"]
];


$doc[] = $row = fhtml("@row");
$row["@col-6"] = pt()->card(
    "Table striped",
    pt("@table-responsive-sm @table-striped")->table($tableData, ["col1"=>"Column 1", "col2" => "Column 2"])
);

$row["@col-6"] = pt()->card(
    "Table bordered",
    pt("@table-responsive-sm @table-bordered")->table($tableData, ["col1"=>"Column 1", "col2" => "Column 2"])
);

// Full row with both: row-Renderer and column-Renderer
$row = $doc["@row"];
$row["@col-12"] = pt()->card(
    "Table with individual renderers (row-Renderer and column-Renderer)",
    pt("@table-responsive-sm @table-striped")->table(
        $tableData,
        ["col1"=>"Column 1", "col2" => "Column 2", "action"=>""],
        function (FHtml $tr, $rowData) {
            if ($rowData["col1"] == "Col 1 Row 2 Data")
                $tr->alter("@bg-success");
            return $tr;
        },
        [
            "action" => function ($data, $rowData) {
                return ["button @btn @btn-primary" => "Click"];
            }
        ]

    )
);



$table = new Table(["#", "Name", "Description"]);
$table->row([1, "Some Name", "Some Description"], "@class=bg-primary");

$doc[] = $row = fhtml("@row");
$row["@col-6"] = pt()->card("Usage Report", $table);
$row["@col-6"] = pt()->card("Usage Report2", $table);

$h->end_recording();

$doc[] = pt()->view_code($h->getCode());


return $doc;
