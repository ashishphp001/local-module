
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
    <head>
        <title>CMS Plugin</title>
        <link href="<?php echo GLOBAL_ADMIN_CSS_PATH; ?>style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="popup-brd" style="overflow:scroll;height:300px;width:310px;">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <td valign="top" height="10px">&nbsp;</td>
                        <td valign="top" height="10px">&nbsp;</td>
                    </tr>
                    <?php if ($cmsdata != '1') { ?>
                    
                        <tr><td><h2>
                                    
                                   <strong style="align:center;font-size: 16px;">Common Files</strong>
                            
                            </td></tr>
                        <tr>
                            <td valign="top" height="10px">&nbsp;</td>
                            <td valign="top" height="10px">&nbsp;</td>
                        </tr>
                        <tr id="abcd"><td>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tbody><tr>
                                            <td valign="top" height="10px">&nbsp;</td>
                                            <td valign="top" height="10px">

                                            </td>
                                        </tr>
                                        <?php
                                        $rowcount = 0;

                                        if ($counttotal > 0) {
                                            foreach ($selectAll as $row) {
                                            $fileexntension = substr(strrchr($row->varFile, '.'), 1);
                                            $filetolowwer = strtolower($fileexntension);
                                            $p = explode('.', $row->varFile);
                                                $totalrow[] = $row;

                                                if ($filetolowwer == 'pdf' || $filetolowwer=='PDF') {
                                                     $arrfiletype = 'acrobate-readericon.png';
                                                     $Front_image = 'pdf';
                                                    $arrpdf[] = $row;
                                                }
                                                if ($filetolowwer == 'doc' || $filetolowwer == 'docx' || $filetolowwer=='DOC' ||$filetolowwer=='DOCX') {
                                                    $arrzip[] = $row;
                                                }
                                                if ($filetolowwer == 'rar' || $filetolowwer == 'zip') {
                                                    $arrzip1[] = $row;
                                                }
                                                 if ($filetolowwer == 'xls' || $filetolowwer == 'xlsx' || $filetolowwer=='XLS' ||$filetolowwer=='XLSX') {
                                                    $arrxls[] = $row;
                                                }
                                                 if ($filetolowwer == 'ppt' || $filetolowwer == 'pptx' || $filetolowwer=='PPT' ||$filetolowwer=='PPTX') {
                                                    $arrppt[] = $row;
                                                }
                                               
                                                $rowcount++;
                                            }
                                            ?>
                                            <tr><td><h2><a href="javascript:;" style="cursor:pointer;color:#0053a5;font-size:14px;font-weight: bold;" onClick="javascript:expandcollapsepanel('pdfdata');">PDF Files</a></h2></td></tr>
                                            <tr id="pdfdata">
                                                <td>
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                            </tr>
                                                            <?php
                                                            if (count($arrpdf) > 0) {
                                                                $i = 1;
                                                                foreach ($arrpdf as $value) {
                                                                    ?>
                                                                    <tr>
                                                                        <td width="9%" valign="top" style="border-bottom: 1px solid rgb(221, 221, 221); padding: 5px 25pt 6px 0;">
                                                                            <input type="checkbox"  name="page<?php echo $i ?>" id="page<?php echo $i ?>" value=""><label for="page<?php echo $i ?>" style="padding-left:10px;"><?php echo $value->varTitle ?></label>
                                                                         <input type="hidden" name="<?php echo $i; ?>" id="<?php echo $i; ?>" value="<?php echo htmlspecialchars("<br /><div ><a href='" . SITE_PATH . "upimages/commonfiles/" . $value->varFile . "' target='_blank'><img style=width:15px;height:15px; src='" . base_url() . "admin-media/images/$arrfiletype' />  " . $value->varTitle . "</a><div class='spacer1'></div></div>"); ?>">
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b style="font-weight:bold;">No Records Found for PDF Files</b>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                            <tr><td><center><h2><a href="javascript:;" style="cursor:pointer;color:#0053a5;font-size:14px;font-weight: bold;" onClick="javascript:expandcollapsepanel('docdata');">Doc Files</a></h2></center></td></tr>
                                            <tr id="docdata">
                                                <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                            </tr>
                                                            <?php
                                                            if (count($arrzip) > 0) {
                                                                if (count($arrpdf) > 0) {
                                                                    $i = $i;
                                                                } else {
                                                                    $i = 1;
                                                                }
                                                                foreach ($arrzip as $value) {
                                                                    ?>
                                                                    <tr>
                                                                         <td width="9%" valign="top" style="border-bottom: 1px solid rgb(221, 221, 221); padding: 5px 0pt;">
                                                                             <input type="checkbox" name="page<?php echo $i ?>" id="page<?php echo $i ?>" value="<?php echo $value->varTitle ?>"><label for="page<?php echo $i ?>" style="padding-left:10px;"><?php echo $value->varTitle ?></label>
                                                                            <input type="hidden" name="<?php echo $i; ?>" id="<?php echo $i; ?>" value="<?php echo htmlspecialchars("<br /><div ><a href='" . SITE_PATH . "upimages/commonfiles/" . $value->varFile . "' target='_blank'><img src='" . base_url() . "admin-media/images/WORD.png' />  " . $value->varTitle . "</a><div class='spacer1'></div></div>"); ?>">
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b style="font-weight:bold;">No Records Found for Doc Files</b>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                    </table></td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                            <tr><td><center><h2><a href="javascript:;" style="cursor:pointer;color:#0053a5;font-size:14px;font-weight: bold;" onClick="javascript:expandcollapsepanel('xlsdata');">Xls Files</a></h2></center></td></tr>
                                            <tr id="xlsdata">
                                                <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                            </tr>
                                                            <?php
                                                            if (count($arrxls) > 0) {
                                                                if (count($arrpdf) > 0) {
                                                                    $i = $i;
                                                                } else {
                                                                    $i = 1;
                                                                }
                                                                foreach ($arrxls as $value) {
                                                                    ?>
                                                                    <tr>
                                                                        <td width="9%" valign="top" style="border-bottom: 1px solid rgb(221, 221, 221); padding: 5px 0pt;">
                                                                            <input type="checkbox" name="page<?php echo $i ?>" id="page<?php echo $i ?>" value="<?php echo $value->varTitle ?>"><label for="page<?php echo $i ?>" style="padding-left:10px;"><?php echo $value->varTitle ?></label>
                                                                            <input type="hidden" name="<?php echo $i; ?>" id="<?php echo $i; ?>" value="<?php echo htmlspecialchars("<br /><div ><a href='" . SITE_PATH . "upimages/commonfiles/" . $value->varFile . "' target='_blank'><img src='" . base_url() . "admin-media/images/xls-icon.png' />  " . $value->varTitle . "</a><div class='spacer1'></div></div>"); ?>">
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b style="font-weight:bold;">No Records Found for Doc Files</b>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                    </table></td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                            <tr><td><center><h2><a href="javascript:;" style="cursor:pointer;color:#0053a5;font-size:14px;font-weight: bold;" onClick="javascript:expandcollapsepanel('pptdata');">PPT Files</a></h2></center></td></tr>
                                            <tr id="pptdata">
                                                <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                               
                                                            </tr>
                                                            <?php
                                                            if (count($arrppt) > 0) {
                                                                if (count($arrpdf) > 0) {
                                                                    $i = $i;
                                                                } else {
                                                                    $i = 1;
                                                                }
                                                                foreach ($arrppt as $value) {
                                                                    ?>
                                                                    <tr>
                                                                        <td width="9%" valign="top" style="border-bottom: 1px solid rgb(221, 221, 221); padding: 5px 0pt;">
                                                                            <input type="checkbox" name="page<?php echo $i ?>" id="page<?php echo $i ?>" value=""><label for="page<?php echo $i ?>" style="padding-left:10px;"><?php echo $value->varTitle ?></label>
                                                                            <input type="hidden" name="<?php echo $i; ?>" id="<?php echo $i; ?>" value="<?php echo htmlspecialchars("<br /><div ><a href='" . SITE_PATH . "upimages/commonfiles/" . $value->varFile . "' target='_blank'><img src='" . base_url() . "admin-media/images/ppt-icon.png' />  " . $value->varTitle . "</a><div class='spacer1'></div></div>"); ?>">
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b style="font-weight:bold;">No Records Found for Doc Files</b>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                    </table></td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                            <tr><td><center><h2><a href="javascript:;" style="cursor:pointer;color:#0053a5;font-size:14px;font-weight: bold;" onClick="javascript:expandcollapsepanel('rarfile');">Zip Files</a></h2></center></td></tr>
                                            <tr id="rarfile">
                                                <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody><tr>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                                <td valign="top" height="10px">&nbsp;</td>
                                                            </tr>
                                                            <?php
                                                            if (count($arrzip1) > 0) {
                                                                if (count($arrpdf) > 0 && count($arrzip) > 0) {
                                                                    $i = $i;
                                                                } else if (count($arrpdf) == 0 && count($arrzip) == 0) {
                                                                    $i = 1;
                                                                }
                                                                foreach ($arrzip1 as $value) {
                                                                    ?>
                                                                    <tr>
                                                                        <td width="9%" valign="top" style="border-bottom: 1px solid rgb(221, 221, 221); padding: 5px 0pt;">
                                                                            <input type="checkbox" name="page<?php echo $i ?>" id="page<?php echo $i ?>" value=""><label for="page<?php echo $i ?>" style="padding-left:10px;"><?php echo $value->varTitle ?></label>
                                                                            <input type="hidden" name="<?php echo $i; ?>" id="<?php echo $i; ?>" value="<?php echo htmlspecialchars("<br /><div ><a href='" . SITE_PATH . "upimages/commonfiles/" . $value->varFile . "'><img src='" . base_url() . "admin-media/images/mime_zip.png' />" . $value->varTitle . "</a><div class='spacer1'></div></div>"); ?>">
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b style="font-weight:bold;">No Records Found for Rar Files</b>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                    </table></td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                            </td>
                            </tr>
                        <?php } else { ?>
                             <tr>
                                <td colspan="2">
                                    <b style="font-weight:bold;">No Records Found for Common Files</b>
                                </td>
                            </tr>
                            <?php
                        }
                    } ?>
                <input type="hidden" id="countcommonfile" name="countcommonfile" value="<?php echo $rowcount ?>" />
                </tbody>
            </table>
        </div>
    </body>
</html>