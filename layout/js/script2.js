
// the edite page
var userAttribute=document.querySelectorAll("input[type='text'] ,  input[type='password'] , input[type='email'] , select ,textarea"),
    userlabels=document.querySelectorAll(" label"),
    videos=document.querySelectorAll(".controls .vid-btn"),
    video=document.querySelector("#video");
var index;
console.log(userAttribute);
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
videos.forEach(btn=>{
    btn.onclick= ()=>{
        document.querySelector(".controls .active").classList.remove("active");
        btn.classList.add("active");
        video.setAttribute("src",btn.getAttribute("data-scr"));
}});