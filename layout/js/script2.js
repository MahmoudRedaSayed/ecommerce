
// the edite page
var userAttribute=document.querySelectorAll("input[type='text'] ,  input[type='password'] , input[type='email'] , select ,textarea"),
    userlabels=document.querySelectorAll(" label"),
    videos=document.querySelectorAll(".controls .vid-btn"),
    video=document.querySelector("#video");
var index;
videos.forEach(btn=>{
    btn.onclick= ()=>{
        document.querySelector(".controls .active").classList.remove("active");
        btn.classList.add("active");
        video.setAttribute("src",btn.getAttribute("data-scr"));
}});
// /////////////////////////////////
// function to reply on the comments
var replybtns=document.querySelectorAll('#replybtn'),
    replyblocks=document.querySelectorAll('#replycomment');
    var index;
replybtns.forEach((replybtn, index) => {
    replybtn.onclick=()=>{
        if(replyblocks[index].style.display=="none")
            {
                replyblocks[index].style.display="block";
                replybtn.innerHTML='unreply';
            }
            else
            {
                replyblocks[index].style.display="none";
                replybtn.innerHTML='reply';
            }
    }
});
////////////////////////////////////////
// function to replies on the comments
var repliesbtns=document.querySelectorAll('#repliesbtn'),
    repliesblocks=document.querySelectorAll('#replies');
    var index;
    console.log(repliesbtns);
    console.log(repliesblocks);
repliesbtns.forEach((replybtn, index) => {
    replybtn.onclick=()=>{
        if(repliesblocks[index].style.display=="none")
            {
                repliesblocks[index].classList.add('replies');
                repliesblocks[index].style.display="flex";
                replybtn.innerHTML='hide replies';
            }
            else
            {
                repliesblocks[index].classList.remove('replies');
                repliesblocks[index].style.display="none";
                replybtn.innerHTML='show replies';
            }
    }
});
var bars=document.getElementById('bars');
bars.onclick=()=>{
    if(document.getElementById('links').style.display!='none')
    {
        document.getElementById('links').style.display='none'
    }
    else
    {
        document.getElementById('links').style.display='block';
    }
}
var cross=document.querySelector('.setarrival i'),
    appear=document.getElementById("appear");
console.log(appear);
console.log(cross);
if(appear!=null){
    appear.onclick=()=>{
        document.getElementById('setarrival').style.clipPath= "polygon(0 0,100% 0,100% 100%,0 100%)";
        document.getElementById('id').setAttribute("value",appear.getAttribute('value'));
    }
}
if(cross!=null)
{
    cross.onclick=()=>{
        document.getElementById('setarrival').style.clipPath= "polygon(0 0,100% 0,100% 0,0 0)";
    }
}
var cover=document.getElementById('changecover'),
    profile=document.getElementById('changeprofile'),
    inputfield=document.querySelectorAll('#changeinput');
console.log(cover);
console.log(inputfield);
console.log(document.forms['myForm1']);
cover.onclick=()=>{
    inputfield[0].click();
}
// setInterval(() => {
//     document.forms["myForm1"].submit();
// }, 1);
profile.onclick=()=>{
    inputfield[1].click();
    document.forms["myForm2"].submit();
}
// setInterval(() => {
//     document.forms["myForm2"].submit();
// }, 1);
