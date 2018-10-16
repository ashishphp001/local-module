
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
    <head>
        <title>CMS Plugin</title>
        <link href="<? //=GLOBAL_ADMIN_CSS_PATH   ?>style.css" rel="stylesheet" type="text/css" />
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
                        <tr><td><h2><a href="javascript:;" style="cursor:pointer;font-size:20px;" onClick="javascript:expandcollapsepanel('abcd');">Common Files</a></h2></td></tr>
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
                                               
                                                $extension = explode('.', $row->var_pdffile);
                                                $p = count($extension);
                                                $extension1 = $extension[$p - 1];

                                                $totalrow[] = $row;

                                                if ($extension1 == 'pdf') {
                                                    $arrpdf[] = $row;
                                                }
                                                if ($extension1 == 'doc' || $extension1 == 'docx') {
                                                    $arrzip[] = $row;
                                                }
                                                if ($extension1 == 'rar' || $extension1 == 'zip') {
                                                    $arrzip1[] = $row;
                                                }
                                                $rowcount++;
                                            }
                                            ?>
                                            <tr><td><h2><a href="javascript:;" style="cursor:pointer;" onClick="javascript:expandcollapsepanel('pdfdata');">PDF Files</a></h2></td></tr>
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
                                                                        <td width="9%" valign="top" style="border-bottom: 1px solid rgb(221, 221, 221); padding: 5px 0pt;">
                                                                            <input type="checkbox" name="page<?php echo $i ?>" id="page<?php echo $i ?>" value=""><span style="padding-left:10px;"><?= $value->var_title ?></span>
                                                                            <input type="hidden" name="<?php echo $i; ?>" id="<?php echo $i; ?>" value="<?php echo htmlspecialchars("<br /><div ><a href='" . SITE_PATH . "upimages/commonpdf/" . $value->var_pdffile . "' target='_blank'><img src='" . base_url() . "admin-media/images/acrobate-readericon.png' />  " . $value->var_title . "</a><div class='spacer1'></div></div>"); ?>">
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
                                            <tr><td><center><h2><a href="javascript:;" style="cursor:pointer;" onClick="javascript:expandcollapsepanel('docdata');">Doc Files</a></h2></center></td></tr>
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
                                                                            <input type="checkbox" name="page<?php echo $i ?>" id="page<?php echo $i ?>" value=""><span style="padding-left:10px;"><?= $value->var_title ?></span>
                                                                            <input type="hidden" name="<?php echo $i; ?>" id="<?php echo $i; ?>" value="<?php echo htmlspecialchars("<br /><div ><a href='" . SITE_PATH . "upimages/commonpdf/" . $value->var_pdffile . "' target='_blank'><img src='" . base_url() . "admin-media/images/WORD.png' />  " . $value->var_title . "</a><div class='spacer1'></div></div>"); ?>">
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
                                            <tr><td><center><h2><a href="javascript:;" style="cursor:pointer;" onClick="javascript:expandcollapsepanel('rarfile');">Rar Files</a></h2></center></td></tr>
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
                                                                            <input type="checkbox" name="page<?php echo $i ?>" id="page<?php echo $i ?>" value=""><span style="padding-left:10px;"><?= $value->var_title ?></span>
                                                                            <input type="hidden" name="<?php echo $i; ?>" id="<?php echo $i; ?>" value="<?php echo htmlspecialchars("<br /><div ><a href='" . SITE_PATH . "upimages/commonpdf/" . $value->var_pdffile . "'><img src='" . base_url() . "admin-media/images/zip.gif' />" . $value->var_title . "</a><div class='spacer1'></div></div>"); ?>">
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
                    }
                    ?>
                <input type="hidden" id="countcommonfile" name="countcommonfile" value="<?= $rowcount ?>" />
                </tbody>
            </table>
        </div>
    </body>
</html>