<?php

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DynaFormController extends Controller
{
    private $accessToken;

    public function __construct()
    {
    }
    function get(Request $r)
    {

        $steps = StepController::list($r->processId, $r->taskId);
        foreach($steps as $step){
            if($step->step_type_obj === "DYNAFORM"){
                $dynaform = $step->step_uid_obj;
            }
            $triggers = $step->triggers;
            foreach($triggers as $trigger){
                if($trigger->st_type === "BEFORE"){
                    TriggerController::excute($trigger->tri_uid, $r->caseId);
                }
            }
        }
        if (!$dynaform) {
            return response("شناسه فرم پیدا نشد", 400);
        }
        $variable_values = (new GetCaseVarsController())->getByCaseId($r->caseId);
        $variables = VariableController::getByProcessId($r->processId);
        return view("PMViews::dynamic-forms.main-form")->with([
            'html' => DynaFormController::getHtml($r->processId, $r->caseId, $dynaform, $r->processTitle, $r->caseTitle, $variable_values),
            'vars' => $variables,
            'variable_values' => $variable_values,
            'input_docs' => InputDocController::list($r->appUid),
            'processId' => $r->processId,
            'processTitle' => $r->processTitle,
            'caseId' => $r->caseId,
            'taskId' => $r->taskId,
            'caseTitle' => $r->caseTitle,
            'delIndex' => $r->delIndex,
        ]);
    }

    public static function getJson($processId, $dynaId)
    {
        $accessToken = AuthController::getAccessToken();
        $json =  CurlRequestController::send(
            $accessToken,
            "/api/1.0/workflow/project/$processId/dynaform/$dynaId"
        );
        return $json;
    }

    public static function getHtml($processId, $caseId, $dynaId, $processTitle, $caseTitle, $variable_values)
    {
        $accessToken = AuthController::getAccessToken();
        $json =  CurlRequestController::send(
            $accessToken,
            "/api/1.0/workflow/project/$processId/dynaform/$dynaId"
        );
        $content = json_decode($json->dyn_content);
        $fields = $content->items[0]->items;
        echo "<form action='javascript:void(0)' id='main-form' enctype='multipart/form-data'>";
        echo "<div class='row' style='border-bottom: solid 1px black'>
                <h4>$caseTitle - $processTitle</h4>
                <button type='button' style='flex: auto; text-align: left' class='close' data-dismiss='modal'
                    aria-hidden='true'>&times;</button>
            </div>";
        foreach ($fields as $rows) {
            echo "<div class='row' style='margin-bottom: 20px'>";
            foreach ($rows as $field) {
                $field_name = isset($field->name) ? $field->name : '';
                $field_value = isset($variable_values->$field_name) ? $variable_values->$field_name : '';
                $field_required = isset($field->required) and $field->required ? 'required' : '';
                if (isset($field->mode)) {
                    switch ($field->mode) {
                        case "view":
                            $field_mode = "readonly";
                            break;
                        default:
                            $field_mode = "";
                            break;
                    }
                } else {
                    $field_mode = "";
                }
                if (isset($field->type)) {
                    if ($field->type == "hidden") {
                        echo  "<div class='col-sm-$field->colSpan'>";
                        echo  "<input type='hidden' name='$field->name' class='form-control' value='$field_value' >";
                        echo  "</div>";
                    }
                    if ($field->type == "text") {
                        echo  "<div class='col-sm-$field->colSpan'>";
                        echo  "$field->label: <input type='text' name='$field->name' class='form-control' value='$field_value' $field_required $field_mode>";
                        echo  "</div>";
                    }
                    if ($field->type == "datetime") {
                        $date = new SDate();
                        $field_value = $date->toGrDate($field_value);
                        echo  "<div class='col-sm-$field->colSpan'>";
                        echo  "$field->label: <input type='text' name='$field->name' class='form-control persian-date' value='$field_value' $field_required $field_mode>";
                        echo  "</div>";
                    }
                    if ($field->type == "textarea") {
                        echo  "<div class='col-sm-$field->colSpan'>";
                        echo  "$field->label: <textarea name='$field->name' class='form-control' $field_required $field_mode>$field_value</textarea>";
                        echo  "</div>";
                    }
                    if ($field->type == 'radio') {
                        echo  "<div class='col-sm-$field->colSpan'>";
                        echo  "$field->label: ";
                        echo "<div>";
                        foreach ($field->options as $opt) {
                            $check = $field_value == $opt->value ? 'checked' : '';
                            $field_mode = $field_mode ? 'disabled' : '';
                            echo  "<input type='radio' value='$opt->value' name='$field->name' $check $field_mode>$opt->label <br>";
                        }
                        echo "</div>";
                        echo  "</div>";
                    }
                    if ($field->type == 'dropdown') {
                        echo  "<div class='col-sm-$field->colSpan'>";
                        echo  "$field->label: ";
                        echo "<div class='form-group'>";
                        echo "<select name='$field->name' class='form-control select2' $field_required $field_mode>";
                        foreach ($field->options as $opt) {
                            $selected = $field_value == $opt->value ? 'selected' : '';
                            echo  "<option value='$opt->value' name='$field->name' $selected>$opt->label</option>";
                        }
                        echo "</select>";
                        echo "</div>";
                        echo  "</div>";
                    }
                    if ($field->type == 'file') {
                        echo  "<div class='col-sm-$field->colSpan'>";
                        echo  "$field->label: ";
                        echo "<div style='text-align: center'>";
                        if ($field_value != '') {
                            // print_r($field_value);
                            $values = json_decode($field_value);
                            // print_r($values);
                            $doc = InputDocController::get($caseId, $values[0]);
                            if($field->mode != 'view'){
                                // echo "<label for='$field->inp_doc_uid' class='btn'>Select Image</label>";
                                echo "<input id='$field->inp_doc_uid' type='file' name='$field->inp_doc_uid' class='form-control' >";
                            }
                            echo "<a href='https://pmaker.altfuel.ir/sysworkflow/en/neoclassic/$doc->app_doc_link' >$doc->app_doc_filename</a>";
                            

                        } else {
                            if($field->mode != 'view'){
                                echo "<input id='$field->inp_doc_uid' type='file' name='$field->inp_doc_uid' class='form-control'>";
                            }
                        }
                        echo "</div>";
                        echo "</div>";

                    }
                }
            }
            echo "</div>";
        }
        echo '</form>';
    }
}
