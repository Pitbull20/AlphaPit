<?php
require_once __DIR__ . '/framework/autoload.php';
require_once __DIR__ . '/project/autoload.php';

$argv = $_SERVER['argv'];
array_shift($argv);

if (empty($argv)) {
    echo "AlphaPit CLI\n";
    echo "Usage:\n";
    echo "  php alpha.php serve [host:port]\n";
    echo "  php alpha.php g module <Name>\n";
    echo "  php alpha.php g controller <Module> <Name>\n";
    echo "  php alpha.php g service <Module> <Name>\n";
    echo "  php alpha.php g entity <Module> <Name>\n";
    exit(0);
}

$command = array_shift($argv);

switch ($command) {
    case 'serve':
        $addr = $argv[0] ?? 'localhost:8000';
        $cmd = sprintf('php -S %s -t project/public', escapeshellarg($addr));
        passthru($cmd);
        break;

    case 'g':
    case 'generate':
        $type = $argv[0] ?? null;
        $name = $argv[1] ?? null;
        $extra = $argv[2] ?? null;
        if (!$type || !$name) {
            fwrite(STDERR, "Missing arguments\n");
            exit(1);
        }
        generate_component($type, $name, $extra);
        break;

    default:
        fwrite(STDERR, "Unknown command: $command\n");
        exit(1);
}

function generate_component(string $type, string $name, ?string $extra): void
{
    $base = __DIR__ . '/project/src';
    switch ($type) {
        case 'module':
            $dir = "$base/$name";
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $className = ucfirst($name) . 'Module';
            $content = "<?php\nnamespace App\\$name;\n\nuse AlphaPit\\Module;\n\nclass $className extends Module\n{\n    public array $controllers = [];\n    public array $providers = [];\n}\n";
            file_put_contents("$dir/$className.php", $content);
            echo "Module created: $dir/$className.php\n";
            break;
        case 'controller':
            if (!$extra) {
                fwrite(STDERR, "Specify module name for controller\n");
                exit(1);
            }
            $module = $name;
            $name = $extra;
            $dir = "$base/$module";
            if (!is_dir($dir)) {
                fwrite(STDERR, "Module does not exist: $module\n");
                exit(1);
            }
            $className = ucfirst($name) . 'Controller';
            $ns = "App\\$module";
            $content = "<?php\nnamespace $ns;\n\nuse AlphaPit\\Controller;\nuse AlphaPit\\Attributes\\Route;\n\nclass $className extends Controller\n{\n    #[Route('GET', '/$name')]\n    public function index(): void\n    {\n        // TODO: implement\n    }\n}\n";
            file_put_contents("$dir/$className.php", $content);
            echo "Controller created: $dir/$className.php\n";
            break;
        case 'service':
            if (!$extra) {
                fwrite(STDERR, "Specify module name for service\n");
                exit(1);
            }
            $module = $name;
            $name = $extra;
            $dir = "$base/$module";
            if (!is_dir($dir)) {
                fwrite(STDERR, "Module does not exist: $module\n");
                exit(1);
            }
            $className = ucfirst($name) . 'Service';
            $ns = "App\\$module";
            $content = "<?php\nnamespace $ns;\n\nclass $className\n{\n    // TODO: implement\n}\n";
            file_put_contents("$dir/$className.php", $content);
            echo "Service created: $dir/$className.php\n";
            break;
        case 'entity':
            if (!$extra) {
                fwrite(STDERR, "Specify module name for entity\n");
                exit(1);
            }
            $module = $name;
            $name = $extra;
            $dir = "$base/$module";
            if (!is_dir($dir)) {
                fwrite(STDERR, "Module does not exist: $module\n");
                exit(1);
            }
            $className = ucfirst($name) . 'Entity';
            $ns = "App\\$module";
            $table = strtolower($name) . 's';
            $content = "<?php\nnamespace $ns;\n\nuse AlphaPit\\Entity;\n\nclass $className extends Entity\n{\n    protected string $table = '$table';\n}\n";
            file_put_contents("$dir/$className.php", $content);
            echo "Entity created: $dir/$className.php\n";
            break;
        default:
            fwrite(STDERR, "Unknown component type: $type\n");
            exit(1);
    }
}
