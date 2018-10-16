<style>
    .uk-input-group-addon {
        width: 262px;
        vertical-align: middle;
        line-height: 1;
        text-align: left;
        padding: 0 16px;
        font-size: 16px;
        min-width: 22px;
    }
    .uk-input-group{
        width: 75%;
    }
</style>
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Membership Plans</a></li>
                <li>
                    <span> <?php
                        $title1 = $Row_plans['varName'];
                        if (strlen($title1) > 80) {
                            $title = substr($Row_plans['varName'], 0, 80) . "...";
                        } else {
                            $title = $Row_plans['varName'];
                        }
                        if (!empty($eid)) {
                            echo 'Edit Plan - ' . $title;
                        } else {
                            echo 'Add Plan';
                        }
                        ?>
                    </span>
                </li>
            </ul>
        </div>

        <?php
        $attributes = array('name' => 'Frmplans', 'id' => 'Frmplans', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        echo form_open($action, $attributes);
        echo form_hidden('ehintglcode', $eid);
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-form-row">
                    <input type="hidden" id="intCountFeatures" name="intCountFeatures" value="<?php echo count($getFeaturesList); ?>">
                    <?php
                    foreach ($getFeaturesList as $rows) {
                        $getFeatureData = $this->Module_Model->getFeatureData($eid, $rows['int_id']);
                        ?>
                        <div class="uk-width-large">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><?php echo $rows['varName']; ?>&nbsp;:&nbsp;</span>
                                <?php
                                $priceBoxdata = array(
                                    'name' => 'varFeature_' . $rows['int_id'],
                                    'id' => 'varFeature_' . $rows['int_id'],
                                    'value' => $getFeatureData['varName'],
                                    'class' => 'md-input'
                                );
                                echo form_input($priceBoxdata);
                                ?>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-form-row">
                        <button class="md-btn md-btn-primary md-btn-wave-light" type="submit" name="btnsaveandc" value="btnsaveandc" id="btnsaveandc">Save &amp; Keep Editing</button>
                        <button class="md-btn md-btn-primary md-btn-wave-light" type="submit" name="btnsaveande" id="btnsaveande">Save &amp; Exit</button>
                        <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                            <div  class="md-btn md-btn-wave">
                                Cancel
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>