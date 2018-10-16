function GetXmlHttpObject() {
    var e = null;
    try {
        e = new XMLHttpRequest
    } catch (t) {
        try {
            e = new ActiveXObject("Msxml2.XMLHTTP")
        } catch (t) {
            e = new ActiveXObject("Microsoft.XMLHTTP")
        }
    }
    return e
}
function UpdatePublish(module, tablename, fieldname, intglcode, othertable, value)
{
    var Check_Session = Check_Session_Expire();
    if (Check_Session == 'N')
    {
        var SessUserEmailId = USER_EMAILID
        SessionUpdatePopUp(SessUserEmailId);
    } else
    {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Your browser does not support XMLHTTP!");
            return;
        }
        var temp = '';

        if (tablename == 'rf_Pages')
        {
            if (document.getElementById('PageNumber').value != '')
            {
                temp = '&PageNumber=' + document.getElementById('PageNumber').value;
            }

            if (document.getElementById('PageSize').value != '')
            {
                temp += '&PageSize=' + document.getElementById('PageSize').value;
            }
        }



        if (othertable == '')
        {
            var url = BASE + "adminpanel/" + module + "/updatePublish?tablename=" + tablename + "&fieldname=" + fieldname + "&value=" + value + "&id=" + intglcode + temp;
        } else
            var url = BASE + "adminpanel/" + module + "/updatePublish?tablename=" + tablename + "&fieldname=" + fieldname + "&value=" + value + "&id=" + intglcode + "&othertablename=" + othertable + temp;
        xmlHttp.onreadystatechange = function ()
        {

            if (xmlHttp.readyState == 1)
            {
                SetBackground();
            }
            if ((xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") && (xmlHttp.status == 200))
            {
                var result = xmlHttp.responseText;
                if (tablename == 'rf_Pages')
                {
                    $('#gridbody').replaceWith(result);
                    $('.buttononoff').each(function ()
                    {
                        $(this).jqxSwitchButton({
                            height: 27,
                            width: 81,
                            checked: $(this).attr('data-val')

                        });

                        $(this).bind('checked', function (event)
                        {
                            UpdatePublish('dashboard', $(this).attr('tablename'), $(this).attr('field'), $(this).attr('data-id'), '', 'N')
                        });

                        $(this).bind('unchecked', function (event)
                        {
                            UpdatePublish('dashboard', $(this).attr('tablename'), $(this).attr('field'), $(this).attr('data-id'), '', 'Y')
                        });

                    });
                } else
                {
                    if (result == 1)
                    {

                    } else
                    {
                        alert("Sorry could not update...");
                    }
                }

                UnsetBackground();
            }
        };
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}
function SendGridBindRequestTrashmanager(e, t, n, r, i, s)
{
//    alert("asd");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            if (xmlHttp.readyState == 1) {
                SetBackground()
            }
            if ((xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") && xmlHttp.status == 200) {
                var e = xmlHttp.responseText;
                document.getElementById(t).innerHTML = "";
                document.getElementById(t).innerHTML = e;
                UnsetBackground();
                switch (n) {
                    case"R":
                        UIkit.modal.alert("The record(s) has been successfully restored.");
                        break;
                    case"D":
//                          location.reload(); 
//                        UIkit.modal.alert("The record(s) has been successfully deleted.");
                        break;
                }
            }
        };

        var o = "";
        switch (n) {
            case"D":
                var u = document.getElementsByName(r);
                var a = "";
                var f = 0;
                for (var l = 0; l < u.length; l++) {
                    if (u.item(l).checked == true) {
                        f++;
                        if (a != "")
                            a += ",";
                        a += u.item(l).value
                    }
                }
                if (f == 0) {

                    alert("Please select atleast one record for delete.");
                    return false
                }
//                if (!confirm("Caution! The selected records will be deleted. Press OK to confirm.")) {
//                    return false
//                }
                var c = document.getElementById("ptrecords").value;
                o = "/delete?ptotalr=" + c + "&dids=" + a + "&view=" + i + "&tablename=" + s;
//                alert("asd");
                break;
            case"R":
                var u = document.getElementsByName(r);
                var a = "";
                var f = 0;
                for (var l = 0; l < u.length; l++) {
                    if (u.item(l).checked == true) {
                        f++;
                        if (a != "")
                            a += ",";
                        a += u.item(l).value
                    }
                }
                if (f == 0) {
                    UIkit.modal.alert("Please select atleast one record for restore.");
                    return false
                }
//                if (!confirm("This will restore the selected records. Are you sure you want to continue?")) {
//                    return false
//                }
                var c = document.getElementById("ptrecords").value;
                o = "/restore?ptotalr=" + c + "&rids=" + a + "&tablename=" + s + "&view=" + i;
                break
        }
        xmlHttp.open("GET", e + o + "&ajax=Y", true);
        xmlHttp.send(null)
    } else {
        alert("Your browser does not support HTTP Request.")
    }
    return true
}
function SetBackground() {

//    document.getElementById("dvprocessing").style.display = ""
}
function UnsetBackground() {
//    document.getElementById("dvprocessing").style.display = "none";
//    document.getElementById("dimmer").style.width = 110;
//    document.getElementById("dimmer").style.height = 0;
//    document.getElementById("dimmer").style.visibility = "";
//    altair_helpers.content_preloader_hide();
}
function SendGridBindRequest(url, targetdiv, action, chkidfordelete, flgdisorder, Chr_Banner_Type, flagvalue, textstr, view, catid)
{
//     alert(action);
    var Check_Session = Check_Session_Expire();
    if (Check_Session == 'N')
    {
        var SessUserEmailId = USER_EMAILID
        SessionUpdatePopUp(SessUserEmailId);
    } else
    {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp != null)
        {
            xmlHttp.onreadystatechange = function ()
            {
                if (xmlHttp.readyState == 1)
                {
                    SetBackground();
                }

                if ((xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") && (xmlHttp.status == 200))
                {
                    var str = trim(xmlHttp.responseText);
                    document.getElementById(targetdiv).innerHTML = '';
                    document.getElementById(targetdiv).innerHTML = str;

                    if (typeof makesortable !== 'undefined' && $.isFunction(makesortable)) {
                        makesortable()
                    }

                    if ($("#PaymentHistorypage").val() == 'Y') {
                        var DateFormat = $("#CalendarDateFormat").val();

//                        $("#StartDate").datepicker({
//                            changeMonth: true,
//                            changeYear: true,
//                            maxDate: 0,
//                            dateFormat: DateFormat,
//                            onSelect: function (selectedDate) {
//                                var option = "minDate";
//                                var instance = $('#EndDate').data("datepicker");
//                                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
//                                date.setDate(date.getDate() + 1);
//                                $('#EndDate').datepicker("option", option, date);
//                            }
//                        });
                        //                        var date2 = $("#StartDate").datepicker("getDate");
                        //                        date2.setDate(date2.getDate() + 1);
//                        $("#EndDate").datepicker({
//                            changeMonth: true,
//                            changeYear: true,
//                            maxDate: 0,
//                            dateFormat: DateFormat
//                        });

                        $(".Searchbox").each(function () {
                            $(this).keypress(function (event) {
                                //               filterGrid();
                                var keycode = (event.keyCode ? event.keyCode : event.which);
                                if (keycode == '13') {
                                    filterGrid();
                                    //alert('in');
                                }
                            });
                        });
                    }

                    $('.buttononoff').each(function () {
                        $(this).jqxSwitchButton({
                            height: 27,
                            width: 81,
                            checked: $(this).attr('data-val')

                        });
                        $(this).bind('checked', function (event) {

                            UpdatePublish('dashboard', $(this).attr('tablename'), $(this).attr('field'), $(this).attr('data-id'), '', 'N')
                        });

                        $(this).bind('unchecked', function (event) {

                            UpdatePublish('dashboard', $(this).attr('tablename'), $(this).attr('field'), $(this).attr('data-id'), '', 'Y')
                        });

                    });



//                    $('.tooltip').tooltipster({
//                        interactive: true,
//                        contentAsHTML: true,
//                        animation: 'fade',
//                        position: 'bottom'
//                    });
//
//                    $(".tooltip").hover(function () {
//                        div_id = '.' + $(this).attr('id') + '_value';
//                        var content = $(div_id).html();
//                        $(this).tooltipster('content', content);
//                    });

                    // Restricted_Access();            // to provide access control


                    if (flagvalue != '' && (flagvalue == 'uman' || flagvalue == 'ser' || flagvalue == 'gen'))
                    {
                        if (flagvalue == 'uman')
                        {
                            var textareaid = 'main_description';
                            var boxwidth = 'auto';
                            var toolbartype = 'Default';
                        } else if (flagvalue == 'gen')
                        {
                            var textareaid = 'var_general_tc';
                            var boxwidth = '830';
                            var toolbartype = 'OnlyBasic';
                        } else
                        {
                            var textareaid = 'var_email_signature';

                            if (CKEDITOR.instances['var_general_tc'])
                            {
                                CKEDITOR.remove(CKEDITOR.instances['var_general_tc']); // with or without this line of code - rise an error }
                            }
                            var boxwidth = '830';
                            var toolbartype = 'OnlyBasic';
                        }

                        var editorInstance;



                        editorInstance = CKEDITOR.replace(textareaid, {
                            toolbar: toolbartype,
                            skin: 'moono',
                            width: boxwidth,
                            filebrowserBrowseUrl: '../../ckeditor/pdw_file_browser/index.php?editor=ckeditor',
                            filebrowserUploadUrl: '../../ckeditor/pdw_file_browser/swfupload/Quickupload.php?editor=ckeditor',
                            filebrowserImageBrowseUrl: '../../ckeditor/pdw_file_browser/index.php?editor=ckeditor&filter=image',
                            filebrowserFlashBrowseUrl: '../../ckeditor/pdw_file_browser/index.php?editor=ckeditor&filter=flash'
                        });


                        if (flagvalue == 'uman')
                        {
                            if (document.getElementById('chr_maintenance').checked == true)
                            {
                                document.getElementById('ckeditordiv').style.display = '';
                                document.getElementById('ckeditormaindiv').style.display = '';
                            } else
                            {
                                document.getElementById('ckeditordiv').style.display = 'none';
                                document.getElementById('ckeditormaindiv').style.display = 'none';
                            }
                        }
                    }

                    UnsetBackground();



                    switch (action)
                    {
                        case 'S': // to set the focus on the search text field
                            document.getElementById('SearchTxt1').focus();
                            break;

                        case 'Gtop': // to set the focus on the go to page text field on top
                            document.getElementById('txtgotopagetop').focus();
                            break;

                        case 'Gbottom': // to set the focus on the go to page text field on bottom
                            document.getElementById('txtgotopagebottom').focus();
                            break;

                        case 'D': // This is when the delete button is clicked
 location.reload(); 
//                            UIkit.modal.alert("The records have been deleted successfully.");
                            break;

                        case 'none': // This is for delete ids directly passed
                            alert("No Records deleted .");
                            break;

                        case 'PS': //This is for for focusing display select box
                            var position = trim(document.getElementById('position').value);
                            document.getElementById('cmbdisplay' + position).focus();
                            break;

                        case 'FT':
                            document.getElementById('filterbytop').focus();
                            break;

                        case 'FB':
                            document.getElementById('filterbybottom').focus();
                            break;
                        case 'FS':
                            document.getElementById('filterbystatus').focus();
                            break;

                        case 'MT':
                            document.getElementById('cmbmodulestop').focus();
                            break;

                        case 'MB':
                            document.getElementById('cmbmodulesbottom').focus();
                            break;
                    }
                }
            };

            var appendurl = '';

            // alert(url);

            switch (action)
            {



                case 'PStop':

                    var pagesize = trim(document.getElementById('cmbdisplaytop').value);

                    if (url.indexOf("?") > -1) {
                        appendurl = '&PageSize=' + pagesize;
                    } else {
                        appendurl = '?PageSize=' + pagesize;
                    }

                    //alert(appendurl)		 ; return false;
                    if (ChkObjects('cmbdisplaytop'))
                    {
                        var filterby = trim(document.getElementById('cmbdisplaytop').value);
                        if (url.indexOf("?") > -1) {
                            appendurl = '&PageSize=' + pagesize + '&view=' + filterby;
                        } else {
                            appendurl = '?PageSize=' + pagesize + '&view=' + filterby;
                        }

                    }

                    break;

                case 'PSbottom':

                    var pagesize = trim(document.getElementById('cmbdisplaybottom').value);

                    //                appendurl = '&pagesize='+pagesize;

                    if (url.indexOf("?") > -1) {
                        appendurl = '&PageSize=' + pagesize;
                    } else {
                        appendurl = '?PageSize=' + pagesize;
                    }

                    if (ChkObjects('cmbmodulesbottom'))
                    {
                        var filterby = trim(document.getElementById('cmbmodulesbottom').value);
                        appendurl = '&PageSize=' + PageSize + '&view=' + filterby;
                    }

                    break;

                case 'S': // This is for search
                    var ExtraSearch;
                    var view;
                    if (ChkObjects('cmbmodulestop')) {
                        view = document.getElementById('cmbmodulestop').value;
                    } else {
                        view = "";
                    }

                    if (view != '') {
                        ExtraSearch = "&view=" + view;
                    } else {
                        ExtraSearch = "";
                    }
                    var searchtxt = trim(document.getElementById('SearchTxt1').value);
                    searchtxt = encodeURIComponent(searchtxt);

                    var searchby = trim(document.getElementById('SearchBy').value);
                    appendurl = '&SearchBy=' + searchby + '&SearchTxt=' + searchtxt + ExtraSearch;

                    if (url.indexOf("?") > -1) {
                        appendurl = '&SearchBy=' + searchby + '&SearchTxt=' + searchtxt;
                    } else {
                        appendurl = '?ajax=Y&SearchBy=' + searchby + '&SearchTxt=' + searchtxt + ExtraSearch;
                    }
                    break;



                case 'FT': // This is for filter

                    var filterby = trim(document.getElementById('filterbytop').value);
                    appendurl = '&FilterBy=' + filterby;

                    break;

                case 'FB': // This is for filter

                    var filterby = trim(document.getElementById('filterbybottom').value);
                    appendurl = '&FilterBy=' + filterby;

                    break;
                case 'FS': // This is for filter

                    var filterby = trim(document.getElementById('filterbystatus').value);
                    appendurl = '&filterbystatus=' + filterby;

                    break;

                case 'Ctop':
                    var cmbstatus = document.getElementById('cmbstatus').value;
                    appendurl = '&cmbstatus=' + cmbstatus;
                    break;

                case 'BANNER_FILTER':
                    var Banner = document.getElementById('BannerFilter').value;
                    appendurl = '&BannerFilter=' + Banner;
                    break;

                case 'SERVICE_TYPE':
                    var fk_Service = document.getElementById('fk_Service').value;
                    appendurl = '&fk_Service=' + fk_Service;
                    break;

                case 'PRODUCT_TYPE':
                    var fk_Product = document.getElementById('fk_Product').value;
                    appendurl = '&fk_Product=' + fk_Product;
                    break;

                case 'CATEGORY_FILTER':
                    var Category = document.getElementById('CategoryFilter').value;
//                    alert(Category);
//                    return false;
                    appendurl = '&CategoryFilter=' + Category;
                    break;

                case 'MVF':
                    var modval = document.getElementById('module').value;
                    appendurl = '&modval=' + modval;
                    break;
                case 'MENU_TYPE':
                    var MenuType = document.getElementById('MenuType').value;
                    appendurl = '&MenuType=' + MenuType;
                    break;

                case 'MT': // This is for filter by modules in trash manager

                    var filterby = trim(document.getElementById('cmbmodulestop').value);
                    var tid = document.getElementById('h_view').value;
                    document.getElementById('trname').value = document.getElementById('cmbmodulestop').value;
                    var pagesize = trim(document.getElementById('cmbdisplaytop').value);

                    $(function ()
                    {
                        var view = document.getElementById('cmbmodulestop').value;
                        var flagChange = false;

                        $("#SearchBy").change(function () {

                            flagChange = true;
                            var changeVal = $("#SearchBy option:selected").val();

                            $("#SearchTxt1").autocomplete({
                                source: "index.php?auto=searchval&module=trashmanager&SearchByVal=" + changeVal + "&view=" + view,
                                term: 'term',
                                minLength: 2,
                                select: function (event, ui) {

                                    $('#SearchTxt1').val(ui.item.id);

                                }
                            });
                        });
                        if (flagChange == false)
                        {
                            $(document).on('keypress', '#SearchTxt1', function () {
                                $(this).autocomplete({
                                    source: "index.php?auto=searchval&module=trashmanager&SearchByVal=" + $("#SearchBy option:selected").val() + "&view=" + view,
                                    term: 'term',
                                    minLength: 2,
                                    select: function (event, ui) {

                                        $('#SearchTxt1').val(ui.item.id);
                                    }
                                });
                            });
                        }
                    });

                    appendurl = '&view=' + filterby + '&PageSize=' + pagesize;
                    window.top.location = url + appendurl;
                    break;

                case 'MR': // This is for filter by modules in trash manager
                    appendurl = "";


                    var modulecode = $("#cmbmodulestop option:selected").val();

                    if (modulecode != 0 && modulecode != undefined)
                    {
                        appendurl = appendurl + '&modulecode=' + modulecode;
                    }

                    var moduleglcode = $("#moduleglcode").val();

                    if (moduleglcode != "" && moduleglcode != undefined)
                    {
                        appendurl = appendurl + '&moduleglcode=' + moduleglcode;
                    }

                    var formtype = $("#cmbformtypetop option:selected").val();

                    if (formtype != 0 && formtype != undefined)
                    {
                        appendurl = appendurl + '&formtype=' + formtype;
                    }

                    var pagesize = trim(document.getElementById('cmbdisplaytop').value);
                    appendurl += '&PageSize=' + pagesize;

                    break;

                case 'MB': // This is for filter by module

                    var filterby = trim(document.getElementById('cmbmodulesbottom').value);
                    var pagesize = trim(document.getElementById('cmbdisplaybottom').value);
                    appendurl = '&view=' + filterby + '&PageSize=' + pagesize;

                    break;


                case 'D': // This is for delete

                    var chkelements = document.getElementsByName(chkidfordelete);
                    var ids = "";
                    var ConfirmFlag;

                    ConfirmFlag = true;
                    var countChecked = 0;
                    for (var i = 0; i < chkelements.length; i++)
                    {
                        if (chkelements.item(i).checked == true)
                        {
                            countChecked++;
                            if (ids != "")
                                ids += ",";
                            ids += chkelements.item(i).value;
                        }
                    }

                    var totalpagerecords = document.getElementById('ptrecords').value;
                    if (flgdisorder != undefined) {
                        flgdisorder = flgdisorder;
                    } else {
                        flgdisorder = '';
                    }
                    appendurl = view + '&ptotalr=' + totalpagerecords + '&dids=' + ids + '&rid=' + flgdisorder + '&categoryid=' + flagvalue + Chr_Banner_Type + catid;
                    //alert(appendurl);
                    break;

                case "D1":
//                k = r;
//                    alert(chkidfordelete);
//                    return false;
//                    var O = document.getElementById("ptrecords").value;
//                    u = "/delete?dids=" + chkidfordelete;
                    var ids = chkidfordelete;
                    appendurl = view + '?dids=' + ids;
                    break;

                case 'Delids': // This is for delete ids directly passed

                    var ids = chkidfordelete;
                    var totalpagerecords = document.getElementById('ptrecords').value;
                    appendurl = '&action=delete&ptotalr=' + totalpagerecords + '&dids=' + ids;
                    break;

                case 'AP': // This is for approve in grid
                    appendurl = '&QT=4';
                    break;

                case 'DISP': // This is for display in grid
                    appendurl = '&action=display&QT=5';
                    break;

                case 'DEFAULT': // This is for display in grid
                    appendurl = '&action=setdefault&QT=5';
                    break;
                case 'PROD_CAT_FILTER':

                    var ProCat = $("#ProCat").val();

                    appendurl = '&ProCat=' + ProCat;

                    break;
                case 'BILL_ATTACHMENT_YEAR_FILTER':

                    var year = $("#Year").val();
                    var month = $("#Month").val();
                    appendurl = '&Year=' + year + '&Month=' + month;

                    break;


                case 'PAYMENTREPORT_YEAR_FILTER':


                    var month = $("#Month").val();
                    appendurl = '&Month=' + month;

                    break;

                case 'PAYMENT_HISTORY_FILTERING':

                    var Name = $("#Name").val();
                    var LocationId = $("#LocationId").val();
                    var AccountId = $("#AccountId").val();
                    var StartDate = $("#StartDate").val();
                    var EndDate = $("#EndDate").val();


                    appendurl = '&Name=' + encodeURIComponent(Name) + '&LocationId=' + LocationId + '&AccountId=' + AccountId + '&StartDate=' + StartDate + '&EndDate=' + EndDate;
                    //                    alert(appendurl);return false;
                    break;



                case 'DO': // This is for bulk display order in grid
                    var totalrows = document.getElementById('ptrecords').value;
                    var ids = "";
                    var values = "";
                    var oldvalues = "";
                    var commonglcode = "";

                    var elementforid = "";
                    var elementforvalues = "";
                    var elementforoldvalues = "";
                    var elementforcommonglcodes = "";

                    for (var i = 0; i < totalrows; i++)
                    {
                        if (ids != "")
                            ids += ",";

                        if (values != "")
                            values += ",";

                        if (oldvalues != "")
                            oldvalues += ",";

                        elementforid = "hdnintglcode" + i;
                        elementforvalues = "displayorder" + i;
                        elementforoldvalues = "hdndisplayorder" + i;

                        if (document.getElementById(elementforvalues).value == "")
                        {
                            alert("Field(s) cannot be left blank.");
                            document.getElementById(elementforvalues).focus();
                            return;
                        }
                        if (document.getElementById(elementforvalues).value == 0)
                        {
                            alert("Sorry! The Display Order Value cannot be Zero.");
                            document.getElementById(elementforvalues).focus();
                            return;
                        }

                        if (trim(document.getElementById(elementforvalues).value) == "")//change by jshah to stop multiple spaces
                        {
                            alert("Field(s) can not be left blank.");
                            document.getElementById(elementforvalues).focus();
                            return;
                        }

                        ids += document.getElementById(elementforid).value;
                        values += document.getElementById(elementforvalues).value;
                        oldvalues += document.getElementById(elementforoldvalues).value;

                        if (flgdisorder)
                        {
                            if (commonglcode != "")
                                commonglcode += ",";
                            elementforcommonglcodes = "hdncommonglcode" + i;
                            commonglcode += document.getElementById(elementforcommonglcodes).value;
                        }
                    }
                    url += "/OrderUpdate?";
//alert(ids);return false;
                    appendurl = 'uids=' + ids + '&uvals=' + values + '&uoldvals=' + oldvalues + '&cmnglcode=' + commonglcode;
                    break;

            }

            url = encodeURI(url + appendurl + '&ajax=Y');
            if (url != '')
            {
                url1 = url.replace(/#/g, "");
                url = url1.replace("undefined", "");
//                url = url1.replace("", "undefined");
//                alert(url);return false;
            }

            xmlHttp.open('GET', url, false);
            //xmlHttp.open('GET', url + '&ajax=Y' + appendurl, true);
            //xmlHttp.open('GET', urlArray[0] +"?"+ appendurl + '&ajax=Y', true);
            xmlHttp.send(null);
        } else
        {
            alert("Your browser does not support HTTP Request");
        }
        return true;
    }
}
function expandcollapsepanel(e, d)
{
    if (document.getElementById(e).style.display == "")
    {
        document.getElementById(e).style.display = "none"
        $("#" + d).removeClass('minus-icn');
        $("#" + d).addClass('plus-icn');
    } else
    {
        document.getElementById(e).style.display = ""
        $("#" + d).removeClass('plus-icn');
        $("#" + d).addClass('minus-icn');
    }
}
function KeycheckOnlyNumeric(e) {
    var t = 0;
    t = document.all ? 3 : document.getElementById ? 1 : document.layers ? 2 : 0;
    if (document.all)
        e = window.event;
    var n = "";
    var r = "";
    if (t == 2) {
        if (e.which > 0)
            n = "(" + String.fromCharCode(e.which) + ")";
        r = e.which
    } else {
        if (t == 3) {
            r = window.event ? event.keyCode : e.which
        } else {
            if (e.charCode > 0)
                n = "(" + String.fromCharCode(e.charCode) + ")";
            r = e.charCode
        }
    }
    if (r >= 65 && r <= 90 || r >= 97 && r <= 122 || r >= 33 && r <= 47 || r >= 58 && r <= 64 || r >= 91 && r <= 96 || r >= 123 && r <= 126 || r == 32) {
        return false
    }
    return true
}
function KeycheckOnlyPhonenumber(e)
{
    var t = 0;
    t = document.all ? 3 : document.getElementById ? 1 : document.layers ? 2 : 0;
    if (document.all)
        e = window.event;
    var n = "";
    var r = "";
    if (t == 2) {
        if (e.which > 0)
            n = "(" + String.fromCharCode(e.which) + ")";
        r = e.which
    } else {
        if (t == 3) {
            r = window.event ? event.keyCode : e.which
        } else {
            if (e.charCode > 0)
                n = "(" + String.fromCharCode(e.charCode) + ")";
            r = e.charCode
        }
    }
    if (r >= 65 && r <= 90 || r >= 97 && r <= 122 || r >= 30 && r <= 39 && r != 32 || r >= 42 && r <= 42 || r >= 44 && r <= 47 && r != 45 || r >= 58 && r <= 64 || r >= 91 && r <= 96 || r >= 123 && r <= 126) {
        return false
    }
    return true
}
function checkemail(e) {
    var t = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return t.test(e)
}
function checkall(e) {
    if (document.getElementById("chkall").checked == true) {
        var t = document.getElementsByName(e);
        for (var n = 0; n < t.length; n++) {
            t.item(n).checked = true
        }
    } else {
        var t = document.getElementsByName(e);
        for (var n = 0; n < t.length; n++) {
            t.item(n).checked = false
        }
    }
}
function onkeydown_search(e, t)
{
    var n = e.which ? e.which : event.keyCode;
    if (n == 13)
    {
        document.getElementById("search").focus()
    }
}
function trim(e, t) {
    return ltrim(rtrim(e, t), t)
}
function ltrim(e, t) {
    t = t || "\\s";
    return e.replace(new RegExp("^[" + t + "]+", "g"), "")
}
function rtrim(e, t) {
    t = t || "\\s";
    return e.replace(new RegExp("[" + t + "]+$", "g"), "")
}
function showDiv(e, t) {
    $("#" + t).show()
}
function hidediv(e) {
    $("#" + e).hide()
}
function ChkObjects(e) {
    if (document.getElementById(e) != null) {
        return true
    } else {
        return false
    }
}
function CountLeft(e, t, n) {
    if (e.value.length > n)
        e.value = e.value.substring(0, n);
    else
        t.value = n - e.value.length
}
function KeycheckAlphaNumeric(e) {
    var t = 0;
    t = document.all ? 3 : document.getElementById ? 1 : document.layers ? 2 : 0;
    if (document.all)
        e = window.event;
    var n = "";
    var r = "";
    if (t == 2) {
        if (e.which > 0)
            n = "(" + String.fromCharCode(e.which) + ")";
        r = e.which
    } else {
        if (t == 3) {
            r = window.event ? event.keyCode : e.which
        } else {
            if (e.charCode > 0)
                n = "(" + String.fromCharCode(e.charCode) + ")";
            r = e.charCode
        }
    }
    if (r >= 31 && r <= 44 || r >= 46 && r <= 47 || r >= 58 && r <= 64 || r >= 65 && r <= 96 || r >= 123 && r <= 126) {
        return false
    }
    return true
}
function CheckValidDispOrder(e) {
    if (e == 0 || e == "") {
        $("#DIV_displayinfo").css("display", "block");
        return false
    } else {
        return true
    }
}
function DisplayOrderSpinner(id, dir, url, urlwithpara, Int_Glcode, fkpages, intParentCategory, fk_category, Chr_Banner_Type)
{
//    alert(id);
    var Check_Session = Check_Session_Expire();
    if (Check_Session == 'N')
    {
        var SessUserEmailId = USER_EMAILID
        SessionUpdatePopUp(SessUserEmailId);
    } else
    {
        SetBackground();
        var oldorder;
        var neworder;
        //alert(url);return false;
        if (dir == 'down')
        {
            oldorder = document.getElementById(id).value;
            neworder = eval(oldorder) + eval(1);

            UpdateDisplayOrder(Int_Glcode, neworder, oldorder, fkpages, url, id, intParentCategory, fk_category, Chr_Banner_Type);
            //SendGridBindRequest(urlwithpara, 'gridbody', 'ST');
        } else if (dir == 'up')
        {
            oldorder = document.getElementById(id).value;
            neworder = eval(oldorder) - eval(1);

            UpdateDisplayOrder(Int_Glcode, neworder, oldorder, fkpages, url, id, intParentCategory, fk_category, Chr_Banner_Type);
            //SendGridBindRequest(urlwithpara, 'gridbody', 'ST');
        }

//        UnsetBackground();
    }
}
function UpdateDisplayOrder(Int_Glcode, neworder, oldorder, Fk_Pages, url, id, intParentCategory, fk_category, Chr_Banner_Type)
{
//      alert(Int_Glcode);
//    alert(neworder + "--" + oldorder);
    jQuery.ajax({
        type: "POST",
        url: url + "OrderUpdate?" + csrfName + "=" + csrfHash + "&pageid=" + Fk_Pages + "&ProCat=" + Fk_Pages + "&intParentCategory=" + intParentCategory + "&ajax=Y",
        data: {
            "uid": Int_Glcode,
            "neworder": neworder,
            "oldorder": oldorder,
            "Chr_Banner_Type": Chr_Banner_Type,
            "intParentCategory": intParentCategory,
            csrf_indibizz: csrfHash,
            "fk_category": fk_category
        },
        async: false,
        success: function (result)
        {
            $("#gridbody").html(result);
//            $('.buttononoff').each(function ()
//            {
//                $(this).jqxSwitchButton({
//                    height: 27,
//                    width: 81,
//                    checked: $(this).attr('data-val')
//
//                });
//
//                $(this).bind('checked', function (event)
//                {
//                    UpdatePublish('dashboard', $(this).attr('tablename'), $(this).attr('field'), $(this).attr('data-id'), '', 'N')
//                });
//
//                $(this).bind('unchecked', function (event)
//                {
//                    UpdatePublish('dashboard', $(this).attr('tablename'), $(this).attr('field'), $(this).attr('data-id'), '', 'Y')
//                });
//
//            });
            return false;
        }
    });

}
function Quick_Edit_Alias_Ajax(Action, URL, title, Eid, Module_Id, AliasNote)
{
    //    alert(Module_Id);
    //     alert("=Action="+Action+"=URL="+URL+"=title="+title+"=Eid="+Eid+"=Module_Id="+Module_Id+"=AliasNote="+AliasNote);
    var Check_Session = Check_Session_Expire();
    if (Check_Session == 'N')
    {
        var SessUserEmailId = USER_EMAILID
        SessionUpdatePopUp(SessUserEmailId);
    } else
    {
        $("#aliasnote").html('');
        if (Action == 'V')
        {
            var url = URL;
            window.open(url, '_blank');
        } else if (Action == 'R')
        {
            makeLowercase('Y', title, decodeURI(Eid), decodeURI(Module_Id));
            $("#varAlias").removeClass('error').addClass('valid');
            $('label[for="varAlias"]').html('');
        } else if (Action == 'C')
        {
            var alias = trim($("#aliaslink").html());
            $("#varAlias").val(alias);

            $("#aliaslabel,#cancel_btn,#update_btn,#regen_btn").hide();
            $("#aliaslink,#edit_btn,#view_btn").show();

            $("#varAlias").removeClass('error').addClass('valid');
            $('label[for="varAlias"],#aliasnote').html('');
        } else if (Action == 'U')
        {
            alias_new = $("#varAlias").val().toString().replace(/\-{2,}/g, '-').toString().replace(/\-$/, '');
            $("#varAlias").val(alias_new);
            if ($("#varAlias").val() != '' && CheckingAlias('varAlias', decodeURI(Eid), decodeURI(Module_Id)) == '0') {
                //alert(aliasstatus); 
                $('#aliasnote').html(AliasNote);
                return false;
            }
            $("label[for='varAlias'],#aliasnote").html('');
            $("#aliaslabel,#cancel_btn,#update_btn,#regen_btn").hide();
            $("#aliaslink,#edit_btn,#view_btn").show();
            if ($("#varAlias").val() != '') {
                $("#aliaslink").html($("#varAlias").val());
            }
            $("#varAlias").removeClass('error').addClass('valid');
        } else
        {
            var alias = trim($("#aliaslink").html());
            $("#varAlias").val(alias);
            $("#aliaslabel,#cancel_btn,#update_btn,#regen_btn").show();
            $("#aliaslink,#edit_btn,#view_btn").hide();
        }
    }
}
function Auto_Alias(Edit, Title, Int_Glcode, Fk_module)
{
//    alert("asd");
    if (trim(document.getElementById('varAlias').value) == '' && trim(document.getElementById(Title).value) != '' && trim($("#aliaslink").html()) == '')
    {
        $("label[for='varAlias']").remove();
        $("#varAlias").removeClass('error');
        makeLowercase(Edit, Title, Int_Glcode, Fk_module);
    }
//copytext();
}
function makeLowercase(Edit, title, Int_Glcode, Fk_module)
{
//    
    UnsetBackground();
    var str = trim(document.getElementById(title).value).toLowerCase();
    var temp = new String(str);
    temp = temp.replace(/[^a-z A-Z 0-9 \-]+/g, '');
    temp = rtrim(temp);
    var strlength = temp.length;
    for (i = 0; i < strlength; i++)
    {
        var alias = temp.split(' ').join('-');
    }
    if (alias == undefined) {
        return false;
    }
    alias = alias.replace(/\-{2,}/g, '-');
    alias = alias.replace(/\-$/, '');

    var Extraurl = '';
//    alert(Fk_module);
    if (Edit == 'Y')
    {
        var eid = Int_Glcode

        if (Fk_module == '147' || Fk_module == '150')
        {
            if (eid != '') {
                var Fk_Module = Fk_module;
                Extraurl = '&eid=' + eid + '&module_id=' + Fk_Module;
            } else {
                var Fk_Module = Fk_module;
                Extraurl = '&module_id=' + Fk_Module;
            }

        } else if (eid != '')
        {
            var Fk_Module = Fk_module;
            Extraurl = '&eid=' + eid + '&module_id=' + Fk_Module;
        } else
        {
            Extraurl = '';
        }
    } else if (Fk_module == 'MTQ3')
    {
        var eid = Int_Glcode
        var Fk_Module = Fk_module;
        Extraurl = '&module_id=' + Fk_Module;
    } else if (Fk_module == 'MTUw')
    {
        var eid = Int_Glcode
        var Fk_Module = Fk_module;
        Extraurl = '&module_id=' + Fk_Module;
    }
//    alert(Extraurl);
    $.ajax({
        type: "POST",
        url: BASE + "adminpanel/dashboard/GetAlias?",
        data: "alias=" + alias + Extraurl + "&" + csrfName + "=" + csrfHash,
        async: true,
        success: function (values) {
            if (Edit == 'Y') {
                document.getElementById('varAlias').value = values;
                $("#aliaslink").html(values);
                $("#aliasurl").show();
            } else {
                $("#aliaslink").html(values);
                $("#aliasurl").show();
                document.getElementById('varAlias').value = values;
            }
        }
    });
    UnsetBackground();
    return true;
}
function CheckingAlias(Alias, eid, module_id)
{
    var iChars = "!@#$%^&*()+=[]\\\';,./{}|\":<>?''";
    var alias = document.getElementById(Alias).value;
    if (alias == '')
    {
        $("#aliasmsg").removeClass("alias-valid").addClass("alias-notvalid");
        $("#" + Alias).focus();
        return false;
    } else if (document.getElementById("varAlias").value.length < 2)
    {
        $("#aliasmsg").removeClass("alias-valid").addClass("alias-notvalid");
        $("#" + Alias).focus();
        return false;
    } else
    {
        for (var i = 0; i < document.getElementById("varAlias").value.length; i++)
        {
            if (iChars.indexOf(document.getElementById("varAlias").value.charAt(i)) != -1)
            {
                $("#aliasmsg").removeClass("alias-valid").addClass("alias-notvalid");
                alert("Alias is not valid.");
                document.getElementById('varAlias').focus();
                return false;
            }
        }

        if (trim(CheckSameAlias(alias, eid, module_id)) == 0)
        {
            $("#aliasmsg").removeClass("alias-valid").addClass("alias-notvalid");
            $('#varAlias').addClass("error");
            $('#aliasnote').html('');
            $('#aliasnote').html('Alias already exists. Please change the alias.');
            $("#" + Alias).focus();
            return false;
        } else
        {
            $("#aliasmsg").removeClass("alias-notvalid").addClass('alias-valid');
            return true;
        }
    }
}
function CheckSameAlias(alias, eid, module_id)
{
    var msg = $.ajax({
        type: "GET",
        url: BASE + "adminpanel/dashboard/IsSameAlias?",
        async: false,
        data: "varAlias=" + (alias) + "&module_id=" + module_id + "&eid=" + eid
    }).responseText;

    return msg;
}
function CheckUrl(url)
{
    var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
    if (RegExp.test(url))
    {
        return true;
    } else
    {
        return false;
    }
}
function generate_seocontent(url, formname)
{

    // alert(formname); die;

    var Check_Session = Check_Session_Expire();
    if (Check_Session == 'N')
    {
        var SessUserEmailId = USER_EMAILID
        SessionUpdatePopUp(SessUserEmailId);
    } else
    {
        var postdata = $("#" + formname).serialize();
        if (formname == 'FrmCategory')
        {
            var description = '';
        } else if (formname == 'Frmtag') {
            var description = '';
        } else if (formname == 'FrmProductCategory') {
            var description = '';
        } else if (formname == 'FrmProductInfo')
        {
            var description = document.getElementById('varShortDescription').value;
            description = description.replace(/&#39;/g, "'");
            description = description.replace(/&quot;/g, '"');
            description = description.replace(/&nbsp;/g, " ");
        } else if (formname == 'Frmlocations')
        {
            var description = document.getElementById('varTitle').value;
            description = description.replace(/&#39;/g, "'");
            description = description.replace(/&quot;/g, '"');
            description = description.replace(/&nbsp;/g, " ");
        } else if (formname == 'Frmservices')
        {
            if (document.getElementById('txtDescription') != '') {
                var description = document.getElementById('txtDescription').value;
            } else {
                var description = document.getElementById('varShortDesc').value;
            }
            description = description.replace(/&#39;/g, "'");
            description = description.replace(/&quot;/g, '"');
            description = description.replace(/&nbsp;/g, " ");
        } else
        {
            var description = CKEDITOR.instances.txtDescription.getData();
            description = description.replace(/&#39;/g, "'");
            description = description.replace(/&quot;/g, '"');
            description = description.replace(/&nbsp;/g, " ");
        }

        $.ajax({
            type: 'POST',
            url: url + 'generate_seocontent?',
            data: postdata + '&ajax=Y&description=' + encodeURIComponent(description),
            async: false,
            success: function (data)
            {
                var str = data.split('*****');
                document.getElementById('varMetaTitle').value = trim(str[0]);
                document.getElementById('varMetaKeyword').value = trim(str[1]);
                document.getElementById('varMetaDescription').value = trim(str[2]);

                if (formname == 'FrmPages')
                {
                    CountLeft(document.FrmPages.varMetaTitle, document.FrmPages.metatitle_left, 200);
                    CountLeft(document.FrmPages.varMetaDescription, document.FrmPages.metadescription_left, 400);
                    CountLeft(document.FrmPages.varMetaKeyword, document.FrmPages.metakeyword_left, 400);
                }
                if (formname == 'FrmProductCategory')
                {
                    CountLeft(document.FrmProductCategory.varMetaTitle, document.FrmProductCategory.metatitle_left, 200);
                    CountLeft(document.FrmProductCategory.varMetaDescription, document.FrmProductCategory.metadescription_left, 400);
                    CountLeft(document.FrmProductCategory.varMetaKeyword, document.FrmProductCategory.metakeyword_left, 400);
                }
                if (formname == 'FrmProductInfo')
                {
                    CountLeft(document.FrmProductInfo.varMetaTitle, document.FrmProductInfo.metatitle_left, 200);
                    CountLeft(document.FrmProductInfo.varMetaDescription, document.FrmProductInfo.metadescription_left, 400);
                    CountLeft(document.FrmProductInfo.varMetaKeyword, document.FrmProductInfo.metakeyword_left, 400);
                }



            }
        });
    }
}
function SessionUpdatePopUp(UserEmailid)
{
    var response = '';
    $.ajax({
        type: "GET",
        url: BASE + "adminpanel/login/login_popup?",
        async: false,
        data: "UserEmailid=" + UserEmailid,
        success: function (data)
        {
            response = data;
        }
    });

    $('#LoginPopup-modal').html(response);
    $('#LoginPopup-modal').dialog({
        autoOpen: false,
        height: 'auto',
        width: '480px',
        modal: true,
        title: "Login Popup"
    });
    $('#LoginPopup-modal').dialog('open');
}
function Check_Session_Expire()
{
    var Check_Session = $.ajax({
        type: "GET",
        url: BASE + "adminpanel/login/Check_Session_Expire",
        async: false
    }).responseText;
    return Check_Session;
}
function ProcessLoader()
{

    //    document.getElementById('dvprocessing').style.display = '';
    document.getElementById('dvprocessing').style.display = '';
}   