<?
namespace Phalcon\Di\Service;
use Phalcon\Di\Service;

abstract class BrandsService {
    /**
     * @param array $brandsAll - all brands from db
     * @param array $brandsMethodist - brands of methodist access
     * @param array $entityBrands - entity brands
     * @param array $data - result array
     * @param string $brandField - the filed in entity for brand_id if that another
     * @return array
     */
    public static function getForChosenEntity(array $brandsAll, array $brandsMethodist, array $entityBrands, $data = array(), $brandField = "brand_id") {
        foreach($brandsAll as $brand) {
            $enabled = ArraysService::inArrayRecursive($brandsMethodist, $brand["id"], "brand_id");
            $selected = ArraysService::inArrayRecursive($entityBrands, $brand["id"], $brandField);
            $data [] = array(
                "id" => $brand["id"],
                "title" => $brand["title"],
                "selected" => $selected? "selected" : "",
                "disabled" => $enabled? "" : "disabled"
            );
        }
        return $data;
    }

    /**
     * Возвращает список брендов для пересохранения (дилера, курса, и тд.)
     * @param $brandsMethodist - все доступные бренды методиста
     * @param $entityBrands - бренды сущности
     * @param array $formBrands - бренды из формы
     * @return array
     */
    public static function getCalculationResult (
        $brandsMethodist,
        $entityBrands,
        array $formBrands
    ) {
        $brandsAll = \Brands::find();
        $data = array();
        foreach($brandsAll as $brand) {
            $issetInMethodist = EntityService::inEntityRecursive($brandsMethodist, $brand->id, "brand_id");
            $issetInEntity = EntityService::inEntityRecursive($entityBrands, $brand->id, "brand_id");

            // если бренд отсутствует у методиста и присудствует у entity
            if(!$issetInMethodist and $issetInEntity) {
                $data[] = $brand;
            }
        }
        if($formBrands===array()) return $data;
        $brandsByForm = \Brands::find("id IN (".implode(",", $formBrands).")");
        foreach($brandsByForm as $brandByForm) {
            $data[] = $brandByForm;
        }

        return $data;
    }

    public static function getStudentBrands($student) {
        $brands = array();
        foreach ($student->StudentsPosts as $sPost) {
            $brands[] = $sPost->StudentsPostsBrands->toArray();
        }
        return $brands;
    }
}