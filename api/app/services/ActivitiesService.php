<?
namespace Phalcon\Di\Service;

abstract class ActivitiesService {

    /**
     * @param array $activitiesAll
     * @param array $activitiesMethodist
     * @param array $entityActivities
     * @param array $data
     * @param string $activityField
     * @return array
     */
    public static function getForChosenEntity(array $activitiesAll, array $activitiesMethodist, array $entityActivities, $data = array(), $activityField = "activity_id") {
        foreach($activitiesAll as  $activity) {
            $enabled = ArraysService::inArrayRecursive($activitiesMethodist,  $activity["id"], "activity_id");
            $selected = ArraysService::inArrayRecursive($entityActivities,  $activity["id"], $activityField);
            $data [] = array(
                "id" =>  $activity["id"],
                "title" =>  $activity["title"],
                "selected" => $selected? "selected" : "",
                "disabled" => $enabled? "" : "disabled"
            );
        }
        return $data;
    }

    /**
     * Возвращает список направления обучения для пересохранения (дилера, студента, и тд.)
     * @param $brandsMethodist
     * @param $entityBrands
     * @param array $formBrands
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
            $issetInMethodist = EntityService::inEntityRecursive($brandsMethodist, $brand->id, "activity_id");
            $issetInEntity = EntityService::inEntityRecursive($entityBrands, $brand->id, "activity_id");

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

    /**
     * Возвращает список всех напр. деят. студента по всем должностям
     * @param $student -- объект студент, типа \Students
     * @return array -- массив типа \Activities
     */
    public static function getStudentActivities($student) {
        $acts = array();
        foreach ($student->StudentsPosts as $sPost) {
            $acts[] = $sPost->StudentsPostsActivities->toArray();
            /*foreach ($sPost->StudentsPostsActivities as $act) {
                $acts[] = $act;
            }*/
        }
        return $acts;
    }
}