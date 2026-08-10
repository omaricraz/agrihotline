<?php

namespace App\Services;

use App\Models\Complaint;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ComplaintImportService
{
    /**
     * @var array<string, string>
     */
    private const HEADER_MAP = [
        'complainant name' => 'complainant_name',
        'complainant_name' => 'complainant_name',
        'name' => 'complainant_name',
        'phone' => 'phone',
        'location' => 'location',
        'village' => 'village',
        'region' => 'region',
        'department' => 'department',
        'description' => 'description',
        'priority' => 'priority',
        'status' => 'status',
    ];

    /**
     * @return array{imported: int, errors: list<string>}
     */
    public function import(string $filePath, int $userId): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

        if ($rows === []) {
            return ['imported' => 0, 'errors' => ['The file is empty.']];
        }

        $headers = array_shift($rows);
        $columnMap = $this->mapHeaders($headers);

        if (! in_array('complainant_name', $columnMap, true)) {
            return ['imported' => 0, 'errors' => ['Missing required column: Complainant Name.']];
        }

        $imported = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $data = $this->extractRowData($row, $columnMap);

            if ($this->isEmptyRow($data)) {
                continue;
            }

            $validator = Validator::make($data, $this->rules());

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    $errors[] = "Row {$rowNumber}: {$message}";
                }

                continue;
            }

            $validated = $validator->validated();

            Complaint::create([
                ...$validated,
                'status' => $validated['status'] ?? 'new',
                'created_by' => $userId,
            ]);

            $imported++;
        }

        return ['imported' => $imported, 'errors' => $errors];
    }

    public function createTemplateSpreadsheet(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Complainant Name',
            'Phone',
            'Location',
            'Village',
            'Region',
            'Department',
            'Description',
            'Priority',
            'Status',
        ];

        foreach ($headers as $columnIndex => $header) {
            $sheet->setCellValue([$columnIndex + 1, 1], $header);
        }

        $sheet->setCellValue([1, 2], 'Ahmed Hassan');
        $sheet->setCellValue([2, 2], '0631234567');
        $sheet->setCellValue([3, 2], 'Hargeisa District');
        $sheet->setCellValue([4, 2], 'Arabaso');
        $sheet->setCellValue([5, 2], config('complaints.regions')[0]);
        $sheet->setCellValue([6, 2], config('complaints.departments')[0]);
        $sheet->setCellValue([7, 2], 'Sample complaint description');
        $sheet->setCellValue([8, 2], 'normal');
        $sheet->setCellValue([9, 2], 'new');

        foreach (range(1, count($headers)) as $columnIndex) {
            $sheet->getColumnDimensionByColumn($columnIndex)->setAutoSize(true);
        }

        return $spreadsheet;
    }

    /**
     * @param  resource  $stream
     */
    public function writeTemplateToStream($stream): void
    {
        $writer = new Xlsx($this->createTemplateSpreadsheet());
        $writer->save($stream);
    }

    /**
     * @param  list<mixed>  $headers
     * @return list<string|null>
     */
    private function mapHeaders(array $headers): array
    {
        $columnMap = [];

        foreach ($headers as $index => $header) {
            $normalized = strtolower(trim((string) $header));
            $columnMap[$index] = self::HEADER_MAP[$normalized] ?? null;
        }

        return $columnMap;
    }

    /**
     * @param  list<mixed>  $row
     * @param  list<string|null>  $columnMap
     * @return array<string, mixed>
     */
    private function extractRowData(array $row, array $columnMap): array
    {
        $data = [];

        foreach ($columnMap as $index => $field) {
            if ($field === null) {
                continue;
            }

            $value = $row[$index] ?? null;
            $data[$field] = is_string($value) ? trim($value) : $value;
        }

        foreach (['village', 'status'] as $optionalField) {
            if (! array_key_exists($optionalField, $data) || $data[$optionalField] === '') {
                $data[$optionalField] = null;
            }
        }

        if (isset($data['priority']) && is_string($data['priority'])) {
            $data['priority'] = strtolower(trim($data['priority']));
        }

        if (isset($data['status']) && is_string($data['status'])) {
            $data['status'] = strtolower(str_replace(' ', '_', trim($data['status'])));
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function isEmptyRow(array $data): bool
    {
        $requiredFields = ['complainant_name', 'phone', 'location', 'region', 'department', 'description'];

        foreach ($requiredFields as $field) {
            if (filled($data[$field] ?? null)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array<string, list<ValidationRule|string>>
     */
    private function rules(): array
    {
        return [
            'complainant_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'location' => ['required', 'string', 'max:255'],
            'village' => ['nullable', 'string', 'max:255'],
            'region' => ['required', Rule::in(config('complaints.regions'))],
            'department' => ['required', Rule::in(config('complaints.departments'))],
            'description' => ['required', 'string'],
            'priority' => ['required', Rule::in(array_keys(config('complaints.priorities')))],
            'status' => ['nullable', Rule::in(array_keys(config('complaints.statuses')))],
        ];
    }
}
