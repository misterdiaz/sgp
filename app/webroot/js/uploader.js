//<![CDATA[ 
$(window).load(function(){
$('#preview').hover(
    function() {
        $(this).find('a').fadeIn();
    }, function() {
        $(this).find('a').fadeOut();
    }
)
$('#file-select').on('click', function(e) {
     e.preventDefault();
    
    $('#file').click();
})

$('input[type=file]').change(function() {
    var file = (this.files[0].name).toString();
    var reader = new FileReader();
    
    $('#file-info').text('');
    $('#file-info').text(file);
    
     reader.onload = function (e) {
        var resultado = e.target.result;
        var data = resultado.split(':');
        var hashes = resultado.split(';');
        var tipo = hashes[0].split(':');
        var mimeTipe = tipo[1].split('/');
        //console.log(resultado);
        $.post( "Usuarios/cambiarImagen", {imagen: resultado}).
        done(function(){
            console.log("completado");
        });
         if(mimeTipe[0] === 'image'){
             $('#preview img').attr('src', resultado);
         }else{
             $('#preview img').attr('src', '/sgp/img/file.png');
         }
         
     }
     //reader.readAsArrayBuffer(this.files[0]);
     reader.readAsDataURL(this.files[0]);
});
});//]]>  