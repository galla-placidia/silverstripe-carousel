use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Control\Controller;



class CarouselImageExtension extends DataExtension {

    /**
     * If $width and $height are greater than 0, it is equivalent to
     * CroppedImage().
     *
     * If only $width is greater than 0, it is equivalent to SetWidth().
     *
     * If only $height is greater than 0, it is equivalent to
     * SetHeight().
     *
     * If neither $width or $height are greater than 0, return the
     * original image.
     *
     * @param  Image_Backend $backend
     * @param  integer $width   The width to set or 0.
     * @param  integer $height  The height to set or 0.
     * @return Image_Backend
     */
    public function MaybeCroppedImageByHeight($width, $height) {
      return $this->owner->getFormattedImage('MaybeCroppedImageByHeight', $width, $height);
    }

    public function generateMaybeCroppedImageByHeight(Image_Backend $backend, $width, $height) {
        /*if ($width > 0 && $height > 0) {
            return $backend->croppedResize($width, $height);
        } else

        if ($width > 0) {
            return $backend->resizeByWidth($width);
        } else*/
        if ($height > 0) {
            return $backend->resizeByHeight($height);
        } else {
            return $backend;
        }
    }

    public function MaybeCroppedImage($width, $height) {
      return $this->owner->getFormattedImage('MaybeCroppedImage', $width, $height);
    }

    public function generateMaybeCroppedImage(Image_Backend $backend, $width, $height) {
        if ($width > 0 && $height > 0) {
            return $backend->croppedResize($width, $height);
        } else

        if ($width > 0) {
            return $backend->resizeByWidth($width);
        } else
        if ($height > 0) {
            return $backend->resizeByHeight($height);
        } else {
            return $backend;
        }
    }

}
