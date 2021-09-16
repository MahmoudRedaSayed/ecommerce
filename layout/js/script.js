$(function(){
    'use strict';
    // user slider 
  $('#user').on("click",()=>{
      $("#usersettings").slideToggle(2000);
  });
  $('input , select').each(function(){
    if($(this).attr('required')=='required')
    {
      $(this).after('<span>*</span>');
    }
  });
  //put the icon of the see password
  $('input[type="password"]').each(function(){
      $(this).after('<i class="fas fa-eye"></i>');
  });
  var pass=$('input[type="password"]');
  $('.fa-eye').hover(()=>{
    pass.attr('type','text');
  },function(){
    pass.attr('type','password');
  });
  //the confirmation message of the delete
  $('.delete').click(()=>
  {
      return confirm('Are you sure?');
  });
  $('.title').each(function(){
    $(this).click(()=>
  {
    $(this).next().next().slideToggle(1000);
  })
});
$('i.up').each(function(){
  $(this).click(()=>
{
  $(this).toggleClass("fa-arrow-circle-down");
  $(this).toggleClass("fa-arrow-circle-up");
  $(this).parent().next().slideToggle(1000);
})
});
$(".itemname").each(function(){
  $(this).click(()=>{
    $('.itemslider').slideToggle(1000);
  });
});
// var itemslider=document.querySelectorAll(".itemslider"),
//     itemname=document.querySelectorAll(".itemname"),
//     index=0;
//   itemname.forEach((item, index) =>{
//   item.click(()=>{
//     itemslider[index].slideToggle(1000);
//   });
// });
});





// <h2 class="text-center h2-text">Add Page</h2>
//             <hr>
            // <form class="container formreg" action="items.php?do=insert" method="POST">
            //             <div class="descripation&name  row" >
            //         <div class="  col-md col-lg col-sm-12 havespan">
            //             <label  class="col-12 col-sm-12 text-center" id="name" for="name"></label>
            //             <input class="col-12 col-sm-12 form-control"  type="text" name='name' id="name" placeholder="name of the item" autocomplete="off" required="required">
            //         </div>
            //         <div class=" col-md col-lg col-sm-12 havespan">
            //             <label class="col-12 col-sm-12 text-center" for="descripation"></label>
            //             <input class="col-12 col-sm-12 form-control"  type="text" name='descripation' id="descripation" placeholder="descripation of the item" autocomplete="off" required="required">
            //         </div>
            //     </div>
            //     <div class="price&country havespan row">
            //     <div class=" col-md col-lg col-sm-12 havespan">
            //             <label class="col-12 col-sm-12 text-center" for="price"></label>
            //             <input class="col-12 col-sm-12 form-control"   type="text" name='price' id="price" placeholder="price" autocomplete="off" required='required'>
            //         </div>
            //         <div class=" col-md col-lg col-sm-12 havespan">
            //             <label class="col-12 col-sm-12 text-center" for="country"></label>
            //             <input class="col-12 col-sm-12 form-control"  type="text" name='country' id="country" placeholder="country of made" autocomplete="off" required="required">
            //         </div>
            //     </div>
            //     <label class="col-12 col-sm-12 text-center" for="stutes"></label>
            //     <div class="stutes  row">
            //     <div class=" col-md-6 col-lg-6 col-sm-12 havespan-select row">
            //         <select class="col form-control" placeholder="stutes" name="stutes" required="required">
            //             <option value="0">...</option>
            //             <option value="1">new</option>
            //             <option value="2">used</option>
            //             <option value="3">old</option>
            //         </select>
            //     </div>
            //     </div>
//                 <div class="save form-row button">
//                     <input type="submit" class="btn btn-primary col-md-2" value="save">
//                     <button href="items.php?do=insert" class="btn btn-primary col-md-2">save</button>
//                 </div>
//             </form>