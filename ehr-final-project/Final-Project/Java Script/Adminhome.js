document.addEventListener("DOMContentLoaded", function(){

   if (window.innerWidth < 992) {
   
       document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
   
           element.addEventListener('click', function (e) {
   
               let nextEl = element.nextElementSibling;
               let parentEl  = element.parentElement;
               let allSubmenus_array =	parentEl.querySelectorAll('.submenu');
   
               if(nextEl && nextEl.classList.contains('submenu')) {	
                   e.preventDefault();	
                   if(nextEl.style.display == 'block'){
                       nextEl.style.display = 'none';
                   } else {
                       nextEl.style.display = 'block';
                   }
               }
           });
       })
   }
   
   }); 
   