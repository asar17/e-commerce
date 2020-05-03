        <div>
        </div>
        <script src="<?php echo $js ?>jquery-3.3.1.min.js"></script>
        <script>
               $(document).ready(function(){
                       $('[placeholder]').focus(function(){
                               $(this).attr('data-text',$(this).attr('placeholder'));
                               $(this).attr('placeholder','');

                       }).blur(function(){
                               $(this).attr('placeholder',$(this).attr('data-text'));

                       });
                       $('input').each(function(){
                               if($(this).attr('required')==='required'){
                                       $(this).after('<span style="color:red;position:absolute;right:30px;top:8px">*</span>');

                               }

                       });
                       $('.confirm').click(function(){
                               return confirm("Are you Sure?");

                       });
                       $('.c .cat h3').click(function(){
                               $(this).next('.view').fadeToggle(500);

                       });
               });
                

        </script>

        <script src="<?php echo $js ?>bootstrap.min.js"></script>
</body>
</html>

        