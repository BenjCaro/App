<?php 

namespace Carbe\App\Services;

/**
 *  PicService est dédié au contrôle des images dans le cadre d'upload
 *  @param string $picture correspond à l'image upload
 *  @param string  $view correspond à la vue de redirection si l'image ne passe pas une étape de controle
 *  @param string $subfolder correspond au répertoire de destination
 * 
 *  @return string $newPictureName correspond au nom de l'image
 */

class PicService {
     
        public static function AvailablePics(string $picture,string $view, string $subfolder) :string {

            $allowedTypes = [".svg", ".jpg", ".png"];
            $allowedMaxSize = 2* 1024 *1024; // correspond à 2 Mo
            $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/svg+xml'];


            $pictureName = basename($_FILES[$picture]['name']);
            $pictureTmp = $_FILES[$picture]['tmp_name'];
            $pictureSize = $_FILES[$picture]['size'];
            
            $pictureExtension = strrchr($pictureName, '.');

            if($pictureSize === 0) {
                Flash::setErrorsForm("image","Image vide", "secondary");
                header("Location: $view");
                exit;  
            }

            if($pictureSize > $allowedMaxSize) {
                Flash::setErrorsForm("image","Image trop lourde", "secondary");
                header("Location: $view");
                exit;  
            }

            $finfo = new \finfo(FILEINFO_MIME_TYPE); // Retourne le type mime

            /* Récupère le mime-type d'un fichier spécifique */
        
            $pictureMime = $finfo->file($pictureTmp);

            if(isset($pictureTmp) && is_uploaded_file($pictureTmp)) {
        
            if(!in_array($pictureExtension, $allowedTypes) || !in_array($pictureMime, $allowedMimes)){
                Flash::set("Extension non autorisée", "secondary");
                header("Location:  $view");
                exit;
            };

            $newPictureName = uniqid('cat_', true) . $pictureExtension;
            $destination = dirname(__DIR__, 2) . "/public/assets/images/{$subfolder}/". $newPictureName;

            if (!move_uploaded_file($pictureTmp, $destination)) {
                Flash::set("Échec du transfert de l'image", "secondary");
                header("Location:  $view");
                exit;
            } }

            return $newPictureName;
        }
}