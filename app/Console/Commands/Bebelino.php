<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Bebelino extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:missing-phones 
                            {csv_file : Path to the CSV file} 
                            {--table=students : Table name to update} 
                            {--index_column=index_number : Index column name} 
                            {--phone_column=phone : Phone column name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update missing phone numbers in database from CSV file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $csvPath = $this->argument('csv_file');
        $tableName = $this->option('table');
        $indexColumn = $this->option('index_column');
        $phoneColumn = $this->option('phone_column');

        if (!file_exists($csvPath)) {
            $this->error("CSV file not found at: {$csvPath}");
            return 1;
        }

        // Read CSV file
        $csvData = array_map('str_getcsv', file($csvPath));
        $headers = array_shift($csvData);

        // Find index of index number and phone columns in CSV
        $csvIndexCol = array_search($indexColumn, $headers);
        $csvPhoneCol = array_search($phoneColumn, $headers);

        if ($csvIndexCol === false || $csvPhoneCol === false) {
            $this->error("Required columns not found in CSV header");
            $this->line("CSV headers: " . implode(', ', $headers));
            return 1;
        }

        // Create a mapping of index_number => phone from CSV
        $csvPhoneMap = [];
        foreach ($csvData as $row) {
            if (!empty($row[$csvIndexCol]) && !empty($row[$csvPhoneCol])) {
                $csvPhoneMap[$row[$csvIndexCol]] = $row[$csvPhoneCol];
            }
        }

        if (empty($csvPhoneMap)) {
            $this->error("No valid phone data found in CSV");
            return 1;
        }

        // Get records with missing phone numbers
        $recordsToUpdate = DB::table($tableName)
            ->whereIn($indexColumn, array_keys($csvPhoneMap))
            ->where(function($query) use ($phoneColumn) {
                $query->whereNull($phoneColumn)
                      ->orWhere($phoneColumn, '');
            })
            ->get([$indexColumn, $phoneColumn]);

        if ($recordsToUpdate->isEmpty()) {
            $this->info("No records with missing phone numbers found");
            return 0;
        }

        // Prepare updates
        $updates = [];
        foreach ($recordsToUpdate as $record) {
            if (isset($csvPhoneMap[$record->{$indexColumn}])) {
                $updates[] = [
                    'index' => $record->{$indexColumn},
                    'phone' => $csvPhoneMap[$record->{$indexColumn}]
                ];
            }
        }

        // Perform updates in a transaction
        DB::beginTransaction();
        try {
            $updatedCount = 0;
            
            foreach ($updates as $update) {
                $affected = DB::table($tableName)
                    ->where($indexColumn, $update['index'])
                    ->update([$phoneColumn => $update['phone']]);
                
                $updatedCount += $affected;
            }
            
            DB::commit();
            
            $this->info("Successfully updated {$updatedCount} records");
            return 0;
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error updating records: " . $e->getMessage());
            return 1;
        }
    }
}
