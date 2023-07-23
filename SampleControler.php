namespace App\Http\Controllers;

use App\Classes\CsvExport;
use App\Classes\CsvImport;

class LinkController extends Controller
{
	//How to use import
    public function import()
    {
        $file_location = storage_path("/app/public/links.csv");
        $csv = new CsvImport($file_location);
        dd($csv->import());
    }

	// How to use export
    public function export()
    {
        $file_name = 'links.csv';
        $csv_file_path = storage_path('app/public/');

        $csv = new CsvExport(Link::class, $file_name, $csv_file_path);
        $csv->setExcludedKeys(['created_at', 'updated_at', 'file']);
        $csv->export();

        return dd('export');
    }
}