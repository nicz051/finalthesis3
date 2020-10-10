
// var $rows = $('#accountstable tr');
// $('#search').keyup(function() {
//     var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
//     $rows.show().filter(function() {
//         var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
//         return !~text.indexOf(val);
//     }).hide();
// });

// const searchFun = () =>{
//     let filter = document.getElementById('search').value.toUpperCase();
//     let accountstable = document.getElementById('accountstable');
//     let tr= accountstable.getElementsByTagName('tr');

//     for (var i=0; i<tr.length; i++){
//         let td =tr[i].getElementsByTagName('td')[0];

//         if (td){
//             let textvalue = td.textContent || td.innerHTML;

//             if (textvalue.toUpperCase().indexOf(filter) > -1){
//                 tr[i].style.display = "";
//             }else{
//                 tr[i].style.display = "none";
//             }
//         }
//     }
// }