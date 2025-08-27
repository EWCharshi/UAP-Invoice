<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $file = $request->file('excel_file');
            
            // Read the Excel file
            $data = Excel::toArray(new class implements ToArray, WithHeadingRow {
                public function array(array $array)
                {
                    return $array;
                }
            }, $file);

            if (empty($data) || empty($data[0])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found in the Excel file or file is empty.',
                ], 400);
            }

            $rows = $data[0]; // Get first sheet
            $locations = [];
            $customers = [];
            $importedCount = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because of 0-based index and header row
                
                try {
                    // Process location if location data exists
                    $locationName = $row['location_name'] ?? $row['pickup_location'] ?? $row['location'] ?? $row['pickup'] ?? $row['from'] ?? null;
                    if (!empty($locationName)) {
                        // Check if location already exists to avoid duplicates
                        $locationExists = false;
                        foreach ($locations as $existingLocation) {
                            if (strtolower(trim($existingLocation['name'])) === strtolower(trim($locationName))) {
                                $locationExists = true;
                                break;
                            }
                        }
                        
                        if (!$locationExists) {
                            $locations[] = [
                                'id' => count($locations) + 1,
                                'name' => trim($locationName),
                                'address' => trim($row['address'] ?? $row['location_address'] ?? '') ?: null,
                                'city' => trim($row['city'] ?? $row['location_city'] ?? '') ?: null,
                                'postal_code' => trim($row['postal_code'] ?? $row['zip'] ?? $row['zipcode'] ?? '') ?: null,
                                'country' => trim($row['country'] ?? $row['location_country'] ?? '') ?: null,
                            ];
                        }
                    }

                    // Process customer if customer data exists
                    $customerName = $row['customer_name'] ?? $row['name'] ?? $row['client_name'] ?? $row['passenger_name'] ?? null;
                    if (!empty($customerName)) {
                        // Check if customer already exists to avoid duplicates
                        $customerExists = false;
                        foreach ($customers as $existingCustomer) {
                            if (strtolower(trim($existingCustomer['name'])) === strtolower(trim($customerName))) {
                                $customerExists = true;
                                break;
                            }
                        }
                        
                        if (!$customerExists) {
                            $customers[] = [
                                'id' => count($customers) + 1,
                                'name' => trim($customerName),
                                'phone' => trim($row['phone'] ?? $row['customer_phone'] ?? $row['mobile'] ?? $row['telephone'] ?? '') ?: null,
                                'email' => trim($row['email'] ?? $row['customer_email'] ?? $row['e-mail'] ?? '') ?: null,
                                'company' => trim($row['company'] ?? $row['organization'] ?? $row['business'] ?? '') ?: null,
                                'address' => trim($row['customer_address'] ?? $row['address'] ?? $row['street'] ?? '') ?: null,
                                'city' => trim($row['customer_city'] ?? $row['city'] ?? '') ?: null,
                                'postal_code' => trim($row['customer_postal_code'] ?? $row['customer_zip'] ?? $row['zip'] ?? '') ?: null,
                                'country' => trim($row['customer_country'] ?? $row['country'] ?? '') ?: null,
                            ];
                        }
                    }

                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                }
            }

            if ($importedCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid data found to import. Please check your Excel file format.',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully processed {$importedCount} rows",
                'locations' => $locations,
                'customers' => $customers,
                'errors' => $errors,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error importing file: ' . $e->getMessage(),
            ], 500);
        }
    }
}
