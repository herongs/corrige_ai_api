<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ScaffoldCommand extends Command
{
  protected $signature = 'crud {table : Nome da tabela}';
  protected $description = 'Cria um scaffold básico para uma tabela';

  public function handle()
  {
    try {
      $tableName = $this->argument('table');
      $routeTableName = str_replace('_', '-', $tableName);
      $modelName = ucfirst(Str::camel($tableName));
      $controllerName = $modelName . 'Controller';

      $this->generateMigration($tableName);
      $this->generateModel($modelName, $tableName);
      $this->generateController($controllerName, $modelName, $tableName, $routeTableName);
      $this->generateRoutes($controllerName, $routeTableName, $tableName);
      $this->generateActions($modelName, $tableName);

      $this->info('Crud gerado com sucesso!');
    } catch (\Throwable $th) {
      $this->error('Ocorreu um erro ao gerar o crud: ' . $th->getMessage());
    }
  }

  public function generateMigration($tableName)
  {
    $migrationName = 'create_' . $tableName . '_table';
    $existingMigrations = glob(database_path('migrations/*_' . $migrationName . '.php'));

    if (!empty($existingMigrations)) {
      $this->error("A classe de migração para a tabela '{$tableName}' já existe.");
      return;
    }

    Artisan::call('make:migration', [
      'name' => $migrationName,
      '--create' => $tableName
    ]);

    $this->info("Migração para a tabela '{$tableName}' gerada com sucesso.");
  }

  protected function generateModel($modelName, $tableName)
  {
    $modelContent = <<<EOT
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class {$modelName} extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected \$table = '{$tableName}';
    protected \$guarded = [];
}
EOT;

    $modelFilePath = app_path('Models/' . $modelName . '.php');
    file_put_contents($modelFilePath, $modelContent);

    $this->info("Modelo '{$modelName}' gerado com sucesso em: {$modelFilePath}");
  }

  protected function generateController($controllerName, $modelName, $tableName, $routeTableName)
  {
    $controllerContent = <<<EOT
<?php
namespace App\Http\Controllers;
use App\Actions\\{$modelName}\Create{$modelName};
use App\Actions\\{$modelName}\Update{$modelName};
use App\Models\\{$modelName};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class {$controllerName} extends Controller
{
    public function all(Request \$request)
    {
        \${$tableName} = {$modelName}::get();
        return \$this->successResponse(\${$tableName});
    }
    public function one(\$id)
    {
        \${$tableName} = {$modelName}::findOrFail(\$id);
        return \$this->successResponse(\${$tableName});
    }
    public function update(Request \$request, Update{$modelName} \$update{$modelName}, \$id)
    {
        \${$tableName} = \$update{$modelName}->handle(\$request, \$id);
        return \$this->successResponse(\${$tableName});
    }
    public function create(Request \$request, Create{$modelName} \$create{$modelName})
    {
        try {
            \${$tableName} = \$create{$modelName}->handle(\$request);
            return \$this->successResponse(\${$tableName}, 201);
        } catch (\Throwable \$th) {
            throw \$th;
        }
    }
    public function search(Request \$request)
    {
        \$search = \$request->has('search') ? \$this->_slugify(\$request->search) : '';
        \$select = [
            '{$tableName}.*',
            DB::raw('unaccent({$tableName}.descricao) as descricao_raw')
        ];
        \${$tableName} = {$modelName}::when(\$request->has('search'), function (\$query) use (\$search) {
            return \$query->whereRaw("LOWER(unaccent({$tableName}.descricao)) LIKE '%{\$search}%'");
        })
            ->where('{$tableName}.ativo', '=', true)
            ->orderBy('id')
            ->select(\$select)
            ->get();
        return \$this->successResponse(\${$tableName});
    }
}
EOT;

    $controllerFilePath = app_path('Http/Controllers/' . $controllerName . '.php');
    file_put_contents($controllerFilePath, $controllerContent);

    $this->info("Controlador '{$controllerName}' gerado com sucesso em: {$controllerFilePath}");
  }

  protected function generateRoutes($controllerName, $routeTableName, $tableName)
  {
    $routeFileName = Str::snake($tableName) . '.php';

    $routeContent = <<<EOT
<?php
use App\Http\Controllers\\{$controllerName};
use Illuminate\Support\Facades\Route;
Route::get('/{$routeTableName}', [{$controllerName}::class, 'all']);
Route::get('/{$routeTableName}/{id}', [{$controllerName}::class, 'one']);
Route::get('/search-{$routeTableName}', [{$controllerName}::class, 'search']);
Route::put('/{$routeTableName}/{id}', [{$controllerName}::class, 'update']);
Route::post('/{$routeTableName}', [{$controllerName}::class, 'create']);
EOT;

    $routeFilePath = base_path('routes/authRoutes/' . $routeFileName);
    file_put_contents($routeFilePath, $routeContent);

    $this->info("Rotas geradas com sucesso em: {$routeFilePath}");
  }

  protected function generateActions($modelName, $tableName)
  {
    $actionsPath = app_path('Actions/' . $modelName);
    if (!is_dir($actionsPath)) {
      mkdir($actionsPath, 0777, true);
    }

    // Gerar o arquivo Create{$modelName}.php
    $createActionContent = <<<EOT
<?php
namespace App\Actions\\{$modelName};
use App\Models\\{$modelName};
use Illuminate\Http\Request;
class Create{$modelName}
{
    public function handle(Request \$request): {$modelName}
    {
        try {
            \$data = \$request->only([
                'descricao',
            ]);
            return {$modelName}::create(\$data);
        } catch (\Throwable \$th) {
            throw \$th;
        }
    }
}
EOT;

    file_put_contents($actionsPath . '/Create' . $modelName . '.php', $createActionContent);

    // Gerar o arquivo Update{$modelName}.php
    $updateActionContent = <<<EOT
<?php
namespace App\Actions\\{$modelName};
use App\Models\\{$modelName};
use Illuminate\Http\Request;
class Update{$modelName}
{
    public function handle(Request \$request, \$id): {$modelName}
    {
        try {
            \$data = \$request->only([
                'ativo',
                'descricao',
            ]);
            \$model = {$modelName}::findOrFail(\$id);
            \$model->fill(\$data);
            \$model->save();
            return \$model;
        } catch (\Throwable \$th) {
            throw \$th;
        }
    }
}
EOT;

    file_put_contents($actionsPath . '/Update' . $modelName . '.php', $updateActionContent);

    $this->info('Ações geradas com sucesso!');
  }
}
