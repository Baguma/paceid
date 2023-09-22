@extends('layouts.master')
@section('page_title', 'Report Data')
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- PivotTable.js libs from ../dist -->
    <link rel="stylesheet" type="text/css" href="/pivotjs/pivot.css">
    <script type="text/javascript" src="/pivotjs/pivot.js"></script>
    <script type="text/javascript" src="/pivotjs/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="/pivotjs/export_renderers.js"></script>
    <script type="text/javascript" src="/pivotjs/c3_renderers.js"></script>
    <!-- FileSaver.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
        /* styles for responsive pivot UI + bootstrap-like styles default */
        .pivotHolder table.pvtUi {
            table-layout:fixed;
        }
        .pivotHolder select {
            visibility:hidden;
        }
        .pivotHolder select.form-control {
            visibility:visible;
        }

        .pivotHolder > table.pvtUi, .pivotHolder table.pvtTable {
            width:auto;
            margin-bottom:0px;
        }
        .pivotHolder > table.pvtUi>tbody>tr>td, .pivotHolder > table.pvtUi>tbody>tr>th {
            border: 1px solid #ddd;
        }
        .pivotHolder .pvtAxisContainer li span.pvtAttr {
            height:auto;
            white-space:nowrap;
        }
        .pivotHolder .pvtAxisContainer.pvtUnused, .pivotHolder .pvtAxisContainer.pvtCols {
            vertical-align:middle;
        }

        .pivotHolder > table.pvtUi>tbody>tr:first-child > td:first-child {
            width:250px;
        }

        .pivotHolder td.pvtRendererArea {
            padding-bottom:0px;
            padding-right:0px;
            border-bottom-width:0px !important;
            border-right-width:0px !important;
        }
        .pivotHolder td.pvtVals br { display:none; }

        .pvtRendererArea>div {
            overflow:auto;
        }

        .pvtTableRendererHolder {
            max-height:500px;  /* limit table height if needed */
        }
        .pvtUi select.pvtRenderer, .pvtUi select.pvtAggregator, .pvtUi select.pvtAttrDropdown {
            float:left;
            max-width:150px;
        }

        /* custom */
        table.pvtUi td:first-child {
            min-width:250px;
            max-width:300px;
            white-space:normal;
        }
        .pvtFixedHeader {
            cursor:pointer;
        }
        td.pvtAxisContainer.pvtRows {
            max-width:300px;
        }
        th.pvtAxisLabel {
            min-width:auto !important;
        }
        .pvtColLabel {
            min-width:100px;
            max-width:200px;
            white-space:normal;
        }
        .pvtRowLabel {
            min-width:150px;
            max-width: 250px;
            white-space:normal;
        }
        .pvtAxisContainer li span.pvtAttr {
            padding: 6px;
            margin-bottom:5px;
            white-space: nowrap;
            background: #fff;
            white-space: normal;
            display: inline-block;
        }
        .pvtFilterBox {
            max-width: 600px;
            width: auto;
            text-align:left;
        }
        .pvtFilterBox p {
            padding:8px;
        }
        .pvtFilterBox p button {
            margin-right:8px;
        }
        table.pvtTable tbody tr th, table.pvtTable thead tr th {
            background-color: #eeeeee;
        }

        .c3-line, .c3-focused {stroke-width: 3px !important;}
        .c3-bar {stroke: white !important; stroke-width: 1;}
        .c3 text { font-size: 12px; color: grey;}
        .tick line {stroke: white;}
        .c3-axis path {stroke: grey;}
        .c3-circle { opacity: 1 !important; }
        .c3-xgrid-focus {visibility: hidden !important;}
    </style>

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Detailed Report</h6>
        </div>

        <div class="card-body">
            <div id="output" class="pivotHolder" style="display: block; padding: 10px 0px;"></div>
        </div>
    </div>


    <script type="text/javascript">
        $(function () {
            var wrappedRenderers = $.extend( {},
                $.pivotUtilities.renderers,
                $.pivotUtilities.export_renderers,
                $.pivotUtilities.c3_renderers,
                $.pivotUtilities.d3_renderers,
                $.pivotUtilities.export_renderers
            );

            /*var nrecoPivotExt = new NRecoPivotTableExtensions({
                wrapWith: '<div class="pvtTableRendererHolder"></div>',  // special div is needed by fixed headers when used with pivotUI
                fixedHeaders : true
            });*/

            var stdRendererNames = ["Table","Table Barchart","Heatmap","Row Heatmap","Col Heatmap"];
            $.each(stdRendererNames, function() {
                var rName = this;
                //wrappedRenderers[rName] = nrecoPivotExt.wrapPivotExportRenderer(nrecoPivotExt.wrapTableRenderer(wrappedRenderers[rName]));
            });

            $("#errors").html('');
            $("#output").html('<div style="text-align:center; margin:0 auto; padding-top:50px;"><span class="blocked" style="margin-bottom:10px; max-width: 100%">Initializing...Please wait...</span></div>').css({'display':'block','padding':'10px 0'});

            var url = "<?php echo url('reports/anaylsisdata'); ?>";
            var sortAs = $.pivotUtilities.sortAs;
            $.getJSON(url, function(data) {
                // var sortconf = '';
                // these are the functions you wish to use
                var functionsConfig = {
                    renderers:   wrappedRenderers,
                    unusedAttrsVertical: 500,
                    sorters: {"Start Month": sortAs(["Jan","Feb","Mar","Apr", "May", "Jun","Jul","Aug","Sep","Oct","Nov","Dec"])},
                    onRefresh: function(config) {
                        var config_copy = JSON.parse(JSON.stringify(config));
                        //delete some values which are functions
                        delete config_copy["aggregators"];
                        delete config_copy["renderers"];
                        //delete some bulky default values
                        delete config_copy["rendererOptions"];
                        delete config_copy["localeStrings"];

                        // this is correct way to apply fixed headers with pivotUI
                        //nrecoPivotExt.initFixedHeaders($('#output table.pvtTable'));

                        // apply boostrap styles to pvt UI controls
                        $('#output select.pvtAttrDropdown:not(.form-control)').addClass('form-control input-sm');
                        // add padding to row and column background images
                        $("td.pvtRows").css({"background":"url(/images/rows_drag.png)", "background-color": "#EEE", "background-repeat": "no-repeat", "background-size":"225px", "background-position": "top center", "padding-top":"50px"});
                        $("td.pvtCols").css({"background":"url(/images/columns_drag.png)", "background-color": "#EEE", "background-repeat": "no-repeat", "background-size":"225px", "background-position": "top left", "padding-top":"20px"});

                        // add padding to row and column background images
                        $("td.pvtAxisContainer.pvtRows li").css({"padding":"0px 5px"});
                        // add description text before the dropdowns
                        if($( "select.pvtRenderer").hasClass('pvtRenderer_filled')){
                        } else {
                            $('<span class="label blocked" style="color:#666; display: block;text-align: left;font-size: 11px; margin-left: -6px;">Format Options</span>').insertBefore( "select.pvtRenderer");
                            $( "select.pvtRenderer").addClass('pvtRenderer_filled');
                        }

                        if($( "select.pvtAggregator").hasClass('pvtRenderer_filled')){
                        } else {
                            $('<span class="label blocked" style="color:#666; display: block;text-align: left;font-size: 11px; margin-left: -6px;">Aggregation Options</span>').insertBefore("select.pvtAggregator");
                            $( "select.pvtAggregator").addClass('pvtRenderer_filled');
                        }

                        // add standard input control classes
                        $('#output select.pvtAggregator:not(.form-control), #output select.pvtRenderer:not(.form-control)').addClass('form-control input-sm');
                        $('#output>table:not(.table)').addClass('table').css({'max-width':'100%'});

                        // hide powered by images
                        $(".pvtTable td:contains('Powered by')").css("color", "#fff");
                        $(".pvtTable a:contains('PivotTable.js')").css("color", "#fff");

                        // if the target of the click isn't the container nor a descendant of the container
                        $(document).mouseup(function(e) {
                            var container = $(".pvtFilterBox");
                            if (!container.is(e.target) && container.has(e.target).length === 0) {
                                container.hide();
                            }
                            return true;
                        });

                        // add config to the textarea for saving
                        $("#serialconfig").text(JSON.stringify(config_copy, undefined, 2));

                        // show dropdown for options
                        $("#gridactions").removeClass("hidden");
                        var renderer  = $('.pvtRenderer option:selected').val(); // alert(renderer);
                        if(renderer != 'Table'){
                            $("a#rawdata").addClass("hidden"); $("a#viewtable").removeClass("hidden");
                            $("a#viewtable").on("click", function(){
                                $('select.pvtRenderer').val('Table').trigger('change');
                            });
                        } else {
                            $("a#viewtable").addClass("hidden"); $("a#rawdata").removeClass("hidden");
                            $("a#rawdata").on("click", function(){
                                $('select.pvtRenderer').val('TSV Export').trigger('change');
                            });
                        }

                        if(renderer == 'TSV Export'){
                            // hide button for other renderers and enable those of raw data
                            $(".canvasaspng, .canvasaspdf, .canvasasjpg").addClass("hidden");
                            $(".rawasexcel, .rawascsv, .rawaspdf, .rawcopy").removeClass("hidden");

                            // download to csv on click
                            $(".pvtRendererArea textarea").attr('id', 'csvcontent');
                            var csv  = $(".pvtRendererArea textarea").html();
                            $("a.rawascsv").on("click", function(){
                                download($.now()+'.csv', csv);
                            });


                            // excel download for raw data

                            //$("a.rawasexcel").on("click", function () {
                            // Get the data in CSV format from the PivotTable
                            var csv = $(".pvtRendererArea textarea").text();

                            // Format the CSV data to separate cells with commas (',')
                            var csvLines = csv.split('\n');
                            var formattedCsv = csvLines.map(function (line) {
                                var lineValues = line.split('\t');
                                return lineValues.join(',');
                            }).join('\n');

                            // Create a Blob from the formatted CSV data
                            var blob = new Blob([formattedCsv], { type: "text/csv;charset=utf-8" });

                            // Create a download link for the Blob
                            var link = document.createElement("a");
                            link.href = URL.createObjectURL(blob);

                            // Set the filename for the download
                            link.download = $.now() + ".csv";

                            // Programmatically trigger a click event on the download link
                            link.click();
                            // });


                            // pdf download for raw data
                            $("a.rawaspdf").on("click", function(){
                                $("#csv_text").val(csv);
                                $("#listform").attr('method', 'post').attr('action', '<?php echo url('download/pdf?nodecode=1'); ?>').attr('target', '_blank').submit();
                            });
                        } else {
                            $(".pvtRendererArea").attr('id', 'content');
                            $(".xcanvasaspng, .canvasaspdf, .canvasasjpg").removeClass("hidden");
                            $(".rawasexcel, .rawascsv, .rawaspdf, .rawcopy").addClass("hidden");
                            var contentclass = 'pvtRendererArea';
                            if(renderer == 'Stacked Bar Chart"'){
                                contentclass = 'c3';
                            }

                            document.querySelector("a.canvasaspng").addEventListener("click", function() {
                                $.blockUI({ message: '<?php echo ""; ?>'});
                                html2canvas(document.querySelector("."+contentclass), {
                                    onrendered: function(canvas) {
                                        // document.body.appendChild(canvas);
                                        Canvas2Image.saveAsPNG(canvas);
                                        $.unblockUI();
                                        return true;
                                    }
                                });
                            });
                            document.querySelector("a.canvasasjpg").addEventListener("click", function() {
                                $.blockUI({ message: '<?php echo ""; ?>'});
                                html2canvas(document.querySelector("."+contentclass), {
                                    onrendered: function(canvas) {
                                        // document.body.appendChild(canvas);
                                        Canvas2Image.saveAsJPEG(canvas);
                                        $.unblockUI();
                                        return true;
                                    }
                                });
                            });
                            document.querySelector("a.canvasaspdf").addEventListener("click", function() {
                                $.blockUI({ message: '<?php echo ""; ?>'});
                                html2canvas(document.querySelector("."+contentclass), {
                                    onrendered: function(canvas) {
                                        var imgData = canvas.toDataURL('image/png');
                                        var doc = new jsPDF('p', 'mm');
                                        doc.addImage(imgData, 'PNG', 10, 10);
                                        doc.save($.now()+'.pdf');
                                        $.unblockUI();
                                        return true;
                                    }
                                });
                            });
                        }
                    }
                };

                $("#output").pivotUI(data, functionsConfig);
            });
        });

        // Function to export data to CSV
        function exportToCSV() {
            var csv = $(".pvtRendererArea textarea").text();
            var blob = new Blob([csv], { type: "text/csv;charset=utf-8" });
            saveAs(blob, $.now() + ".csv");
        }

        // Function to export data to Excel
        function exportToExcel() {
            var csv = $(".pvtRendererArea textarea").text();
            $("#csv_text").val(csv);
            $("#listform").attr('method', 'post').attr('action', '<?php echo url('download/excel?nodecode=1'); ?>').attr('target', '_blank').submit();
        }

        // Function to copy data to clipboard
        function copyToClipboard() {
            var csv = $(".pvtRendererArea textarea").text();
            var clipboard = new ClipboardJS('.rawcopy', {
                text: function() {
                    return csv;
                }
            });
            clipboard.on('success', function(e) {
                alert('Data copied to clipboard.');
                e.clearSelection();
            });
            clipboard.on('error', function(e) {
                alert('Failed to copy data to clipboard. Please copy it manually.');
            });
        }
    </script>
@endsection
