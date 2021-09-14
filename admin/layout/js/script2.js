
// the edite page
var userAttribute=document.querySelectorAll(".formreg input[type='text'] , .formreg input[type='password'] ,.formreg input[type='email'] , select"),
    userlabels=document.querySelectorAll(".formreg label");
    console.log(userAttribute);
    console.log(userlabels);
var index;
userAttribute.forEach((user, index) => {
    if(user.getAttribute('type')!='hidden'&&user.getAttribute('type')!='submit')
    {
        user.onfocus=(function(){
            userlabels[index].innerHTML=user.getAttribute("placeholder");
            user.setAttribute("datatext",user.getAttribute("placeholder"));
            user.setAttribute("placeholder",'');
    });
    user.onblur=(function(){
        userlabels[index].innerHTML="";
        user.setAttribute("placeholder",user.getAttribute("datatext"));
    });
    }
});