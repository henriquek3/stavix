<!DOCTYPE html>
<!-- Copyright (c) Realtek Semiconductor Corp., 2003. All Rights Reserved. -->
<html>
<head>
    <meta
        http-equiv="Content-Type"
        content="text/html"
        charset="utf-8"
    >
    <meta
        HTTP-EQUIV="Pragma"
        CONTENT="no-cache"
    >
    <meta
        HTTP-equiv="Cache-Control"
        content="no-cache"
    >
    <link
        rel="stylesheet"
        href="/admin/reset.css"
    >
    <link
        rel="stylesheet"
        href="/admin/base.css"
    >
    <link
        rel="stylesheet"
        href="/admin/style.css"
    >
    <script
        language="javascript"
        src="common.js"
    ></script>
    <script
        type="text/javascript"
        src="share.js"
    ></script>

    <title>IP/Port Filtering</title>
    <script>
        function skip() {
            this.blur();
        }

        function protocolSelection() {
            if (document.formFilterAdd.protocol.selectedIndex == 2) {
                document.formFilterAdd.sfromPort.disabled = true;
                document.formFilterAdd.stoPort.disabled = true;
                document.formFilterAdd.dfromPort.disabled = true;
                document.formFilterAdd.dtoPort.disabled = true;
            } else {
                document.formFilterAdd.sfromPort.disabled = false;
                document.formFilterAdd.stoPort.disabled = false;
                document.formFilterAdd.dfromPort.disabled = false;
                document.formFilterAdd.dtoPort.disabled = false;
            }
        }

        function addClick(obj) {
            if (document.formFilterAdd.sip.value == "" && document.formFilterAdd.smask.value == ""
                && document.formFilterAdd.dip.value == "" && document.formFilterAdd.dmask.value == ""
                && document.formFilterAdd.sfromPort.value == "" && document.formFilterAdd.dfromPort.value == "") {
                alert('Filter Rules can not be empty');
                document.formFilterAdd.sip.focus();
                return false;
            }
            if (document.formFilterAdd.sip.value != "") {
                if (!checkHostIP(document.formFilterAdd.sip, 0))
                    return false;
                if (document.formFilterAdd.smask.value != "") {
                    if (!checkNetmask(document.formFilterAdd.smask, 0))
                        return false;
                }
            }
            if (document.formFilterAdd.dip.value != "") {
                if (!checkHostIP(document.formFilterAdd.dip, 0))
                    return false;
                if (document.formFilterAdd.dmask.value != "") {
                    if (!checkNetmask(document.formFilterAdd.dmask, 0))
                        return false;
                }
            }
            if (document.formFilterAdd.sfromPort.value != "") {
                if (validateKey(document.formFilterAdd.sfromPort.value) == 0) {
                    alert('Invalid source port!');
                    document.formFilterAdd.sfromPort.focus();
                    return false;
                }
                d1 = getDigit(document.formFilterAdd.sfromPort.value, 1);
                if (d1 > 65535 || d1 < 1) {
                    alert('Invalid source port number!');
                    document.formFilterAdd.sfromPort.focus();
                    return false;
                }
                if (document.formFilterAdd.stoPort.value != "") {
                    if (validateKey(document.formFilterAdd.stoPort.value) == 0) {
                        alert('Invalid source port!');
                        document.formFilterAdd.stoPort.focus();
                        return false;
                    }
                    d1 = getDigit(document.formFilterAdd.stoPort.value, 1);
                    if (d1 > 65535 || d1 < 1) {
                        alert('Invalid source port number!');
                        document.formFilterAdd.stoPort.focus();
                        return false;
                    }
                }
            }
            if (document.formFilterAdd.dfromPort.value != "") {
                if (validateKey(document.formFilterAdd.dfromPort.value) == 0) {
                    alert('Invalid destination port!');
                    document.formFilterAdd.dfromPort.focus();
                    return false;
                }
                d1 = getDigit(document.formFilterAdd.dfromPort.value, 1);
                if (d1 > 65535 || d1 < 1) {
                    alert('Invalid destination port number!');
                    document.formFilterAdd.dfromPort.focus();
                    return false;
                }
                if (document.formFilterAdd.dtoPort.value != "") {
                    if (validateKey(document.formFilterAdd.dtoPort.value) == 0) {
                        alert('Invalid destination port!');
                        document.formFilterAdd.dtoPort.focus();
                        return false;
                    }
                    d1 = getDigit(document.formFilterAdd.dtoPort.value, 1);
                    if (d1 > 65535 || d1 < 1) {
                        alert('Invalid destination port number!');
                        document.formFilterAdd.dtoPort.focus();
                        return false;
                    }
                }
            }
            obj.isclick = 1;
            postTableEncrypt(document.formFilterAdd.postSecurityFlag, document.formFilterAdd);
            return true;
        }

        function disableDelButton() {
            if (verifyBrowser() != "ns") {
                disableButton(document.formFilterDel.deleteSelFilterIpPort);
                disableButton(document.formFilterDel.deleteAllFilterIpPort);
            }
        }

        function on_submit(obj) {
            obj.isclick = 1;
            postTableEncrypt(document.formFilterDefault.postSecurityFlag, document.formFilterDefault);
            return true;
        }

        function deleteClick(obj) {
            if (!confirm('Do you really want to delete the selected entry?')) {
                return false;
            } else {
                obj.isclick = 1;
                postTableEncrypt(document.formFilterDel.postSecurityFlag, document.formFilterDel);
                return true;
            }
        }

        function deleteAllClick(obj) {
            if (!confirm('Do you really want to delete the all entries?')) {
                return false;
            } else {
                obj.isclick = 1;
                postTableEncrypt(document.formFilterDel.postSecurityFlag, document.formFilterDel);
                return true;
            }
        }
    </script>
</head>
<body>
<div class="intro_main ">
    <p class="intro_title">IP/Port Filtering</p>
    <p class="intro_content"> Entries in this table are used to restrict certain types of data
                              packets through the Gateway. Use of such filters can be helpful in
                              securing or restricting your local network. </p>
</div>
<form
    action="/stavix"
    method=POST
    name="formFilterDefault"
>
    <div class="data_common data_common_notitle">
        <table>
            <tr>
                <th width="40%">Default Action:&nbsp;&nbsp;</th>
                <td width="30%">
                    <input
                        type="radio"
                        name="outAct"
                        value=0
                        checked
                    >
                    Deny&nbsp;&nbsp;
                    <input
                        type="radio"
                        name="outAct"
                        value=1
                    >
                    Allow
                </td>
                <td width="30%">
                    <input
                        class="inner_btn"
                        type="submit"
                        value="Apply Changes"
                        name="setDefaultAction"
                        onClick="return on_submit(this)"
                    >
                </td>
            </tr>
            <input
                type="hidden"
                value="/fw-ipportfilter_rg.asp"
                name="submit-url"
            >
            <input
                type="hidden"
                name="postSecurityFlag"
                value=""
            >
        </table>
    </div>
</form>
<form
    action="/stavix"
    method=POST
    name="formFilterAdd"
>
    @csrf
    <div class="data_common data_common_notitle">
        <table>
            <tr>
                <th width="40%">
                    Protocol:
                    <select
                        name="protocol"
                        onChange="protocolSelection()"
                    >
                        <option
                            select
                            value=1
                        >TCP
                        </option>
                        <option value=2>UDP</option>
                        <option value=3>ICMP</option>
                    </select>
                </th>
                <th colspan=2>Rule Action:&nbsp;&nbsp;
                    <input
                        type="radio"
                        name="filterMode"
                        value="Deny"
                        checked
                    >
                              Deny&nbsp;&nbsp;
                    <input
                        type="radio"
                        name="filterMode"
                        value="Allow"
                    >
                              Allow
                </th>
            </tr>
            <tr>
                <th width="40%">
                    Source IP Address:
                    <input
                        type="text"
                        name="sip"
                        size="10"
                        maxlength="15"
                    >
                </th>
                <th width="30%">Subnet Mask:
                    <input
                        type="text"
                        name="smask"
                        size="10"
                        maxlength="15"
                    >
                </th>
                <th width="30%">Port:
                    <input
                        type="text"
                        name="sfromPort"
                        size="4"
                        maxlength="5"
                    >
                                -
                    <input
                        type="text"
                        name="stoPort"
                        size="4"
                        maxlength="5"
                    >
                </th>
            </tr>
            <tr>
                <th width="40%">Destination IP Address:
                    <input
                        type="text"
                        name="dip"
                        size="10"
                        maxlength="15"
                    >
                </th>
                <th width="30%">Subnet Mask:
                    <input
                        type="text"
                        name="dmask"
                        size="10"
                        maxlength="15"
                    >&nbsp;&nbsp;
                </th>
                <th width="30%">Port:
                    <input
                        type="text"
                        name="dfromPort"
                        size="4"
                        maxlength="5"
                    >
                                -
                    <input
                        type="text"
                        name="dtoPort"
                        size="4"
                        maxlength="5"
                    >&nbsp;&nbsp;
                </th>
            </tr>
        </table>
    </div>
    <div class="btn_ctl">
        <input
            class="link_bg"
            type="submit"
            value="Add"
            name="addFilterIpPort"
            onClick="return addClick(this)"
        >
        <input
            type="hidden"
            value="/fw-ipportfilter_rg.asp"
            name="submit-url"
        >
        <input
            type="hidden"
            name="postSecurityFlag"
            value=""
        >
    </div>
</form>
<form
    action=/boaform/formFilter
    method=POST
    name="formFilterDel"
>
    <div class="column">
        <div class="column_title">
            <div class="column_title_left"></div>
            <p>Current Filter Table</p>
            <div class="column_title_right"></div>
        </div>
        <div class="data_common data_vertical">
            <table>
                <tr>
                    <th
                        align=center
                        width="10%"
                    >Select
                    </th>
                    <th
                        align=center
                        width="15%"
                    >Protocol
                    </th>
                    <th
                        align=center
                        width="20%"
                    >Source IP Address
                    </th>
                    <th
                        align=center
                        width="15%"
                    >Source Port
                    </th>
                    <th
                        align=center
                        width="20%"
                    >Destination IP Address
                    </th>
                    <th
                        align=center
                        width="15%"
                    >Destination Port
                    </th>
                    <th
                        align=center
                        width="15%"
                    >Rule Action
                    </th>
                </tr>
                <tr>
                    <td
                        align=center
                        width="10%"
                        bgcolor="#C0C0C0"
                    >
                        <input
                            type="checkbox"
                            name="select0"
                            value="ON"
                        >
                    </td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">TCP</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2">138.97.97.106/32</td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">Allow</td>
                </tr>
                <tr>
                    <td
                        align=center
                        width="10%"
                        bgcolor="#C0C0C0"
                    >
                        <input
                            type="checkbox"
                            name="select1"
                            value="ON"
                        >
                    </td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">TCP</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2">192.168.1.111/32</td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">Allow</td>
                </tr>
                <tr>
                    <td
                        align=center
                        width="10%"
                        bgcolor="#C0C0C0"
                    >
                        <input
                            type="checkbox"
                            name="select2"
                            value="ON"
                        >
                    </td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">UDP</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2">138.97.97.106/32</td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">Allow</td>
                </tr>
                <tr>
                    <td
                        align=center
                        width="10%"
                        bgcolor="#C0C0C0"
                    >
                        <input
                            type="checkbox"
                            name="select3"
                            value="ON"
                        >
                    </td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">ICMP</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2">138.97.97.106/32</td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">Allow</td>
                </tr>
                <tr>
                    <td
                        align=center
                        width="10%"
                        bgcolor="#C0C0C0"
                    >
                        <input
                            type="checkbox"
                            name="select4"
                            value="ON"
                        >
                    </td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">UDP</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2">192.168.1.111/32</td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">Allow</td>
                </tr>
                <tr>
                    <td
                        align=center
                        width="10%"
                        bgcolor="#C0C0C0"
                    >
                        <input
                            type="checkbox"
                            name="select5"
                            value="ON"
                        >
                    </td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">TCP</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2">192.168.1.100/32</td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">443</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">Allow</td>
                </tr>
                <tr>
                    <td
                        align=center
                        width="10%"
                        bgcolor="#C0C0C0"
                    >
                        <input
                            type="checkbox"
                            name="select6"
                            value="ON"
                        >
                    </td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">TCP</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2">192.168.1.100/32</td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">80</td>
                    <td
                        align=center
                        width="20%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2"></td>
                    <td
                        align=center
                        width="15%"
                        bgcolor="#C0C0C0"
                    ><font size="2">Allow</td>
                </tr>

            </table>
        </div>
    </div>
    <div class="btn_ctl">
        <input
            class="link_bg"
            type="submit"
            value="Delete Selected"
            name="deleteSelFilterIpPort"
            onClick="return deleteClick(this)"
        >&nbsp;&nbsp;
        <input
            class="link_bg"
            type="submit"
            value="Delete All"
            name="deleteAllFilterIpPort"
            onClick="return deleteAllClick(this)"
        >&nbsp;&nbsp;&nbsp;
        <input
            type="hidden"
            value="/fw-ipportfilter_rg.asp"
            name="submit-url"
        >
        <input
            type="hidden"
            name="postSecurityFlag"
            value=""
        >
    </div>
    <script>

    </script>
</form>
</body>
</html>
