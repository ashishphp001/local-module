 <div id="gridbody" class="content-wrapper" style="min-height: 699px;">
       
       <section class="content-header">
     <h1> Email Templates</h1>
       </section>
       
  <?php echo  $messagebox; ?>	
      <!--start middle section-->
   
   
   
<!--      <div class="box-header">
        <div class="table_entries">
            <div id="example1_length" class="dataTables_length">
                <?php echo $PagingTop; ?>
            </div>
        </div>

    </div>-->
      <div class="tab_box">
    <div class="col-md-12">
        <div class="spacer10"></div>
        <div class="main-form-box">
            <div class="contact-title">Edit Email Templates</div>
            <div class="spacer10"></div
            > 
     <section id="flip-scroll">		  
           <div class="box-body table-responsive no-padding">
            <table class="table table-hover">  
                <tbody>
                    <tr>
                        <td valign="top" style="vertical-align: top;">
                            <table border="0" cellspacing="0" cellpadding="0" class="table-bordered table-striped table-condensed cf" >
                                <thead class="cf">
                                    <tr><th align="left"><div class="title-text">AdminPanel Email Templates</div></th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($MailTemaplatesArry)) {
                                        echo $MailTemaplatesArry;
                                    } else {
                                        echo '<tr><td align="center" valign="top" class="numeric">'.NO_RECORDS.'</td></tr>';
                                    }
                                    ?>
                                </tbody>
                                <input type="hidden" name="ptrecords" id="ptrecords" value="<?php echo  $rowcount ?>">
                            </table>
                        </td>
                        <td valign="top" style="vertical-align: top;">
                            <table border="0" cellspacing="0" cellpadding="0" class="table-bordered table-striped table-condensed cf" >
                                <thead class="cf">
                                    <tr><th align="left"><div class="title-text">Front Email Templates</div></th></tr>
                                </thead>
                                <tbody>
                                    <?php
//                                    print_r($frontMailTemaplatesArry);exit;
                                    if (!empty($frontMailTemaplatesArry)) {
                                        echo $frontMailTemaplatesArry;
                                    } else {
                                        echo '<tr><td align="center" valign="top" class="numeric">'.NO_RECORDS.'</td></tr>';     
                                    }
                                    ?>
                                </tbody>
                                <input type="hidden" name="ptrecords" id="ptrecords" value="<?php echo  $rowcount ?>">
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
        <div class="spacer10"></div> 
        </div>
    <!--end middle section-->
</div>
</div>
</div>