function ajaxGet(requestUrl) {
        if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
        }
        xmlhttp.open('GET', requestUrl, true);
        xmlhttp.send(null);
        xmlhttp.onreadystatechange = function () {
                if (xmlhttp.status == 200) {
                        console.log(xmlhttp.readyState);
                        if (xmlhttp.readyState == 4) {
                                let back_infos = JSON.parse(xmlhttp.responseText);
                                if (back_infos.code == 0) {
                                        location.href = 'welcome_search.php';
                                } else {
                                        alert(back_infos.msg);
                                        location.href = 'welcome_search.php';
                                }
                        }
                } else {
                        console.log(xmlhttp.responseText);
                        alert('Response failed!');
                }
        }

}

function ajaxPost(requestUrl, requestData) {
        if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
        } 
        xmlhttp.open('POST', requestUrl, true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(requestData);
        xmlhttp.onreadystatechange = function () {
                if (xmlhttp.status == 200) {
                        console.log(xmlhttp)
                        if (xmlhttp.readyState == 4) {
                                let back_infos = JSON.parse(xmlhttp.responseText);
                                if (back_infos.code == 0) {
                                        location.href = 'welcome_search.php';
                                } else {
                                        alert(back_infos.msg);
                                        location.href = 'welcome_search.php';
                                }
                        }
                } else {
                        console.log(xmlhttp.responseText);
                        alert('Response failed!');
                }
        }
}

function ajaxPage(requestUrl, requestData) {
        if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
        } else {
                // IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open('POST', requestUrl, true);

        xmlhttp.onreadystatechange = function () {
                if (xmlhttp.status == 200) {
                        if (xmlhttp.readyState == 4) {

                                let back_infos = JSON.parse(xmlhttp.responseText);

                                let body_html = '';
                                let pages_html = '';
                                let body_infos = back_infos.events_infos;

                                let show_tbody = document.getElementById("show_tbody");

                                if (body_infos.length == 0) {
                                        var strMsg="You currently don't have any events. Try insert them to display here!";
                                        if(requestData){
                                                strMsg="No event matching your expectation!";
                                        }
                                        body_html += "<tr><td style='text-align: center;font-size: 18px;padding:20px 0' colspan='4'>"+strMsg+"</td></tr>";
                                        show_tbody.innerHTML = body_html;
                                        document.getElementById('records').textContent = back_infos.total_records + ' event(s)';
                                } else {
                                        document.getElementById('records').textContent = back_infos.total_records + ' event(s)';
                                }

                                document.getElementById('show_tbody').textContent = '';

                                let body_infos_len = body_infos.length;
                                for (let i = 0; i < body_infos_len; i++) {
                                        body_html += '<tr><td class="td1">' + body_infos[i]['id'] + '</td>';
                                        body_html += '<td class="td2" id="row_name_' + body_infos[i]['id'] + '">' + body_infos[i]['name'] + '</td>';
                                        body_html += '<td class="td3" id="row_level_' + body_infos[i]['id'] + '">' + body_infos[i]['level'] + '</td>';
                                        body_html += '<td class="td4">';
                                        body_html += '<span id="change_click_' + body_infos[i]['id'] + '"' + 'style=" padding-right: 5px">';
                                        body_html += '<a onclick="change_infos(' + body_infos[i]['id'] + ',' + body_infos[i]['urgency_id'] + ');" href="javascript:void(0);" class="edit" name="edit-disabled" id="row_edit_' + body_infos[i]['id'] + '">edit</a>';
                                        body_html += '</span>';
                                        body_html += '<a onclick="deal_del(' + body_infos[i]['id'] + ');" href="javascript:void(0);" class="del" name="del-disabled">delete</a>';
                                        body_html += '</td>';
                                        body_html += '<tr>';
                                }
                                show_tbody.innerHTML = body_html;

                                document.getElementById('pager').textContent = '';
                                let pager = document.getElementById("pager");

                                let total_pages = parseInt(back_infos.total_pages);
                                let search_name = back_infos.search_name;
                                let search_uid = parseInt(back_infos.search_uid);
                                let search_actions = back_infos.search_actions;
                                for (let k = 1; k <= total_pages; k++) {
                                        if (k === 1) {
                                                pages_html += '<a href="javascript:void(0);" onclick="show_infos(1,' + "'" + search_name + "'" + ',' + search_uid + ',' + "'" + search_actions + "'" + ')">First Page</a>';
                                        }

                                        pages_html += '<a href="javascript:void(0);" onclick="show_infos(' + k + ',' + "'" + search_name + "'" + ',' + search_uid + ',' + "'" + search_actions + "'" + ')">' + k + '</a>';
                                        if (k === total_pages) {
                                                pages_html += '<a href="javascript:void(0);" onclick="show_infos(' + total_pages + ',' + "'" + search_name + "'" + ',' + search_uid + ',' + "'" + search_actions + "'" + ')">Last Page</a>';
                                        }
                                }

                                pager.innerHTML = pages_html;
                        }
                } else {
                        console.log(xmlhttp.responseText);
                        alert('Response failed!');
                }
        }
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(requestData);
}