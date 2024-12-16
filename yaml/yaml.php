use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
 
if (!function_exists('yaml_parse_file')) {
    function yaml_parse_file($file){
        try {
            return Yaml::parseFile($file);
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: <b>%s</b>', $exception->getMessage());
        }
    }
}