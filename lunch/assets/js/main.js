
// AddStore.tpl
function check_form(obj)
{
    var err = '';
    if(obj.name.value=="") {err +=" [店名]";}
    if(obj.intro.value=="") {err +=" [簡介]";}
    if(obj.sclass.selectedIndex==0) {err +=" [店家類別]";}
    if(obj.man.value=="") {err +=" [負責人]";}
    if(obj.addr.value=="") {err +=" [地址]";}
    if(obj.tel.value=="") {err +=" [電話]";} 
    if(obj.note.value=="") {err +=" [訂購說明]";} 
    if(err) {alert("請正確輸入 "+err+"");return false;} 
    return true;
}

// EditPds.tpl
function check_form_editpds(obj)
{
    var err = '';
    if(obj.pdsname.value=="") {err +=" [商品名稱]";}
    if(obj.price.value=="") {err +=" [單價]";}
    if(err) {alert("請正確輸入 "+err+"");return false;} 
    return true;
}

// EditStore.tpl
function check_form_editStore(obj)
{
    var err = '';
    if(obj.sname.value=="") {err +=" [店名]";}
    if(obj.intro.value=="") {err +=" [簡介]";}
    if(obj.sclass.selectedIndex==0) {err +=" [店家類別]";}
    if(obj.man.value=="") {err +=" [負責人]";}
    if(obj.addr.value=="") {err +=" [地址]";}
    if(obj.tel.value=="") {err +=" [電話]";} 
    if(obj.note.value=="") {err +=" [訂購說明]";} 
    if(err) {alert("請正確輸入 "+err+"");return false;} 
    return true;
}

// EditManager.tpl
function seldroplist(form,str)
{
    for (var i=0;i<form.length;i++) {
        if (form.options[i].value==str) {
            form.options.selectedIndex=i;
        }
    }
}

// EditStore.tpl
function seldroplisttext(form,str)
{
    for (var i=0;i<form.length;i++) {
        if (form.options[i].value.indexOf(str)!=-1) {
            form.options.selectedIndex=i;
        }
    }
}

// AssignStore.tpl
function myPopUp(url, width, height, top, left)
{
    window.open(url,"Win","resizable=no, scrollbars=yes, width=" + width + ", height=" + height + ", top=" + top + ", left=" + left + ", toolbar=no, ,location=0, menubar=no, status=no, menubat=0, alwaysRaised");
}

function ShowDetail(sid) {
    myPopUp('./index.php?func=store&action=show&id='+sid, 400, 300, 430, 0);
    // window.open('./index.php?func=store&action=show&id='+sid+'','SD','height=300,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}
function ShowPdsInfo(sid) {
    myPopUp('./index.php?func=product&action=list_store&id='+sid, 400, 400, 430, 0);
    // window.open('./index.php?func=product&action=list_store&id='+sid+'','SPI','height=400,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}

function popup(url, width, height)
{   
    window.open(url,"Win","RESIZABLE=no, SCROLLBARS=yes, WIDTH=" + width + ", HEIGHT=" + height + ", TOOLBAR=no,menubar=no,status=no ,alwaysRaised");
}

function popup2(url, name, width, height)
{   
    if(width==0 || height==0)
        window.open(url, name, "RESIZABLE=yes,SCROLLBARS=yes, TOOLBAR=no,menubar=no,status=no ,alwaysRaised ");
    else
        window.open(url, name, "RESIZABLE=yes,SCROLLBARS=yes, WIDTH=" + width + ", HEIGHT=" + height + ", TOOLBAR=no,menubar=no,status=no ,alwaysRaised ");
}
