    jQuery(document).ready(function(){ 

        jQuery("#form_bag_marche").submit(  
        
                function () { 
                         jQuery.post("functionload.php",jQuery("#form_bag_marche").serialize(),
                              function(data) {  
                           
                                            //Se ci sono errori in fase di registrazione 
                                            if(data.errore!='no'){
                                                
                                            jQuery('#err_mess').html('<div style="color:red;">'+data.errore+'</div>').fadeIn(1000);    
                                            }  
                                             else { 
                                                
                                             jQuery('#err_mess').html('<div style="color:green;">Operazione effettuata correttamente</div>').fadeIn(1000);    
                                             setTimeout(function(){window.location.href = "marche.php";},400); 
                                                    
                                                   }                                         
                                             },          
                              "json"
                              );
                 
                           } 
                          );
                  
jQuery("#img_file").fileinput({
        uploadUrl: './funzioni/uploadimg.php?folder=marche', // you must set a valid URL here else you will get an error
        dropZoneEnabled:false,
        language: "it",
        maxFileSize: 16000,
        allowedFileExtensions:    ['jpg','jpeg','gif','png', 'txt','rtf','mp4','mp3','3gp','mov','xls','xlsx','doc','docx','pdf','bmp','jpeg','odt','ods','pptx','ppt','tiff'],
        allowedPreviewTypes: null, // disable preview of standard types
        allowedPreviewMimeTypes: ['image/jpeg','image/png','image/bmp'],// allow content to be shown only for certain mime types
        previewFileIconSettings: {
        'doc': '<i class="fa fa-file-word-o text-primary" style="font-size: 0.6em;"></i>',
        'xls': '<i class="fa fa-file-excel-o text-success" style="font-size: 0.6em;"></i>',
        'ppt': '<i class="fa fa-file-powerpoint-o text-danger" style="font-size: 0.6em;"></i>',
        'jpg': '<i class="fa fa-file-photo-o text-warning" style="font-size: 0.6em;"></i>',
        'pdf': '<i class="fa fa-file-pdf-o text-danger"  style="font-size: 0.6em;"></i>',
        'zip': '<i class="fa fa-file-archive-o text-muted" style="font-size: 0.6em;"></i>',
        'htm': '<i class="fa fa-file-code-o text-info" style="font-size: 0.6em;"></i>',
        'txt': '<i class="fa fa-file-text-o text-info" style="font-size: 0.6em;"></i>',
        'rtf': '<i class="fa fa-file-text-o text-info" style="font-size: 0.6em;"></i>',
        'MOV': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
        '3gp': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
        'mp4': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
        'mp3': '<i class="fa fa-file-audio-o text-warning" style="font-size: 0.6em;"></i>',
        'docx': '<i class="fa fa-file-word-o text-primary" style="font-size: 0.6em;"></i>',
        'xlsx': '<i class="fa fa-file-excel-o text-success" style="font-size: 0.6em;"></i>',
        'pptx': '<i class="fa fa-file-powerpoint-o text-danger" style="font-size: 0.6em;"></i>'
    },
//    initialPreview: [
//        "http://www.ac-websoft.it/immobili/immagini/20-03-2017-12-35-52-logopimmgest.png",
//    ],
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: 'image' // image is the default and can be overridden in config below
//    initialPreviewConfig: [
//        {caption: "20-03-2017-12-35-52-logopimmgest.png", size: 576237, width: "120px", url: "funzioni/deleteimg.php", key: "20-03-2017-12-35-52-logopimmgest.png"},
//    ],

        }).on('fileuploaded', function(event, data, previewId, index) {
          // console.log(data);
            jQuery('<input />').attr('type', 'hidden')
                          .attr('name', "immagine")
                          .attr('value', data.response.nomefile)
                          .appendTo('#form_bag_marche');

              jQuery('#'+ previewId +' > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > button:nth-child(2)').hide();

        });

 });
                