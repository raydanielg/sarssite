<?php

namespace Database\Seeders;

use App\Models\Year;
use App\Models\Level;
use App\Models\Region;
use App\Models\District;
use App\Models\School;
use App\Models\ResultTitle;
use App\Models\Result;
use App\Models\ResultSummary;
use App\Models\ResultType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SampleDataSeeder extends Seeder
{
    private $samplePdfContent = null;

    public function run()
    {
        $this->generateSamplePdf();

        $year2025 = Year::where('year', 2025)->first();
        $year2026 = Year::where('year', 2026)->first();

        $oLevel = Level::where('slug', 'o-level')->first();
        $aLevel = Level::where('slug', 'a-level')->first();

        $mockType = ResultType::where('slug', 'mock-exam')->first();
        $jointType = ResultType::where('slug', 'joint-exam')->first();
        $terminalType = ResultType::where('slug', 'terminal-exam')->first();

        $darRegion = Region::where('slug', 'dar-es-salaam')->first();
        $arushaRegion = Region::where('slug', 'arusha')->first();

        $darDistricts = District::where('region_id', $darRegion->id)->get()->keyBy('name');
        $arushaDistricts = District::where('region_id', $arushaRegion->id)->get()->keyBy('name');

        $schoolsDar = $this->seedSchools($darRegion, $darDistricts, [
            ['code' => 'S0101', 'name' => 'Ilala Secondary School', 'district' => 'Ilala'],
            ['code' => 'S0102', 'name' => 'Jangwani Secondary School', 'district' => 'Ilala'],
            ['code' => 'S0103', 'name' => 'Kisutu Secondary School', 'district' => 'Ilala'],
            ['code' => 'S0104', 'name' => 'Zanaki Secondary School', 'district' => 'Ilala'],
            ['code' => 'S0201', 'name' => 'Kawawa Secondary School', 'district' => 'Kinondoni'],
            ['code' => 'S0202', 'name' => 'Mzimuni Secondary School', 'district' => 'Kinondoni'],
            ['code' => 'S0203', 'name' => 'Makumbusho Secondary School', 'district' => 'Kinondoni'],
            ['code' => 'S0204', 'name' => 'Havard Secondary School', 'district' => 'Kinondoni'],
            ['code' => 'S0301', 'name' => 'Temeke Secondary School', 'district' => 'Temeke'],
            ['code' => 'S0302', 'name' => 'Mbagala Secondary School', 'district' => 'Temeke'],
            ['code' => 'S0303', 'name' => 'Kigamboni Secondary School', 'district' => 'Kigamboni'],
            ['code' => 'S0401', 'name' => 'Ubungo Secondary School', 'district' => 'Ubungo'],
            ['code' => 'S0402', 'name' => 'Makuburi Secondary School', 'district' => 'Ubungo'],
            ['code' => 'S0403', 'name' => 'Mabibo Secondary School', 'district' => 'Ubungo'],
        ]);

        $schoolsArusha = $this->seedSchools($arushaRegion, $arushaDistricts, [
            ['code' => 'S0501', 'name' => 'Arusha Secondary School', 'district' => 'Arusha City'],
            ['code' => 'S0502', 'name' => 'Meru Secondary School', 'district' => 'Arusha City'],
            ['code' => 'S0503', 'name' => 'Kaloleni Secondary School', 'district' => 'Arusha City'],
            ['code' => 'S0601', 'name' => 'Monduli Secondary School', 'district' => 'Monduli'],
            ['code' => 'S0602', 'name' => 'Makuyuni Secondary School', 'district' => 'Monduli'],
            ['code' => 'S0701', 'name' => 'Karatu Secondary School', 'district' => 'Karatu'],
            ['code' => 'S0702', 'name' => 'Mto wa Mbu Secondary School', 'district' => 'Karatu'],
        ]);

        $this->seedResultTitleWithResults($year2025, $oLevel, $darRegion, $darDistricts['Ilala'], $mockType, 'Form Four Mock Exam 2025 - Ilala', $schoolsDar, 'Ilala');
        $this->seedResultTitleWithResults($year2025, $oLevel, $darRegion, $darDistricts['Kinondoni'], $jointType, 'Form Four Joint Exam 2025 - Kinondoni', $schoolsDar, 'Kinondoni');
        $this->seedResultTitleWithResults($year2025, $oLevel, $darRegion, $darDistricts['Temeke'], $terminalType, 'Form Four Terminal Exam 2025 - Temeke', $schoolsDar, 'Temeke');
        $this->seedResultTitleWithResults($year2025, $oLevel, $arushaRegion, $arushaDistricts['Arusha City'], $mockType, 'Form Four Mock Exam 2025 - Arusha City', $schoolsArusha, 'Arusha City');
        $this->seedResultTitleWithResults($year2025, $aLevel, $arushaRegion, $arushaDistricts['Karatu'], $jointType, 'A-Level Joint Exam 2025 - Karatu', $schoolsArusha, 'Karatu');

        $this->seedResultTitleWithResults($year2026, $oLevel, $darRegion, $darDistricts['Ilala'], $mockType, 'Form Four Mock Exam 2026 - Ilala', $schoolsDar, 'Ilala');
        $this->seedResultTitleWithResults($year2026, $oLevel, $darRegion, $darDistricts['Kinondoni'], $jointType, 'Form Four Joint Exam 2026 - Kinondoni', $schoolsDar, 'Kinondoni');
        $this->seedResultTitleWithResults($year2026, $oLevel, $arushaRegion, $arushaDistricts['Arusha City'], $mockType, 'Form Four Mock Exam 2026 - Arusha City', $schoolsArusha, 'Arusha City');
        $this->seedResultTitleWithResults($year2026, $aLevel, $darRegion, $darDistricts['Ubungo'], $terminalType, 'A-Level Terminal Exam 2026 - Ubungo', $schoolsDar, 'Ubungo');

        $this->seedRegionSummary($year2025, $darRegion, 'Dar es Salaam Region Summary 2025 - O-Level');
        $this->seedRegionSummary($year2026, $darRegion, 'Dar es Salaam Region Summary 2026 - O-Level');
        $this->seedRegionSummary($year2025, $arushaRegion, 'Arusha Region Summary 2025 - O-Level');
    }

    private function seedSchools($region, $districts, $schoolsData)
    {
        $schools = collect();

        foreach ($schoolsData as $data) {
            $district = $districts->get($data['district']);
            if (!$district) {
                continue;
            }

            $school = School::updateOrCreate(
                ['code' => $data['code']],
                [
                    'name' => $data['name'],
                    'region_id' => $region->id,
                    'district_id' => $district->id,
                    'is_pc' => rand(0, 1) === 1,
                    'slug' => Str::slug($data['name']),
                ]
            );
            $schools->push($school);
        }

        return $schools;
    }

    private function seedResultTitleWithResults($year, $level, $region, $district, $resultType, $titleName, $schools, $filterDistrict)
    {
        if (!$year || !$level || !$region || !$district || !$resultType) {
            return;
        }

        $slug = Str::slug($titleName . '-' . time() . '-' . rand(1000, 9999));

        $resultTitle = ResultTitle::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $titleName,
                'year_id' => $year->id,
                'level_id' => $level->id,
                'region_id' => $region->id,
                'district_id' => $district->id,
                'result_type_id' => $resultType->id,
            ]
        );

        $filteredSchools = $schools->filter(function ($school) use ($filterDistrict) {
            return Str::contains(strtolower($school->name), strtolower(explode(' ', $filterDistrict)[0])) ||
                   $school->district && Str::slug($school->district->name) === Str::slug($filterDistrict);
        });

        if ($filteredSchools->isEmpty()) {
            $filteredSchools = $schools;
        }

        foreach ($filteredSchools as $school) {
            $fileName = 'results/' . $resultTitle->slug . '/' . $school->code . '-' . Str::slug($school->name) . '.pdf';
            $this->createSamplePdfFile($fileName, $school->name, $resultTitle->name);

            Result::updateOrCreate(
                [
                    'result_title_id' => $resultTitle->id,
                    'school_id' => $school->id,
                ],
                [
                    'description' => 'Results for ' . $school->name,
                    'file_path' => $fileName,
                    'status' => 'Published',
                ]
            );
        }

        $summaryName = 'Summary - ' . $titleName;
        $summaryFile = 'summaries/' . $resultTitle->slug . '/summary.pdf';
        $this->createSamplePdfFile($summaryFile, $summaryName, $resultTitle->name);

        ResultSummary::updateOrCreate(
            [
                'result_title_id' => $resultTitle->id,
                'name' => $summaryName,
            ],
            [
                'file_path' => $summaryFile,
                'status' => 'Published',
            ]
        );
    }

    private function seedRegionSummary($year, $region, $summaryName)
    {
        $slug = Str::slug($summaryName . '-' . time() . '-' . rand(1000, 9999));

        $resultTitle = ResultTitle::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $summaryName,
                'year_id' => $year->id,
                'level_id' => Level::first()->id,
                'region_id' => $region->id,
                'district_id' => null,
                'result_type_id' => ResultType::first()->id,
            ]
        );

        $summaryFile = 'summaries/region-' . $region->slug . '-' . $year->year . '/summary.pdf';
        $this->createSamplePdfFile($summaryFile, $summaryName, 'Region Summary');

        ResultSummary::updateOrCreate(
            [
                'result_title_id' => $resultTitle->id,
                'name' => $summaryName,
            ],
            [
                'file_path' => $summaryFile,
                'status' => 'Published',
            ]
        );
    }

    private function generateSamplePdf()
    {
        $this->samplePdfContent = "%PDF-1.4
1 0 obj
<< /Type /Catalog /Pages 2 0 R >>
endobj
2 0 obj
<< /Type /Pages /Kids [3 0 R] /Count 1 >>
endobj
3 0 obj
<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>
endobj
4 0 obj
<< /Length 120 >>
stream
BT /F1 24 Tf 100 700 Td (SAMPLE RESULT PDF) Tj ET
BT /F1 16 Tf 100 650 Td (This is a sample PDF for testing.) Tj ET
BT /F1 14 Tf 100 600 Td (Generated by SARS Seeder) Tj ET
endstream
endobj
5 0 obj
<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>
endobj
xref
0 6
0000000000 65535 f 
0000000010 00000 n 
0000000060 00000 n 
0000000111 00000 n 
0000000212 00000 n 
0000000387 00000 n 
trailer
<< /Size 6 /Root 1 0 R >>
startxref
452
%%EOF";
    }

    private function createSamplePdfFile($path, $schoolName, $examName)
    {
        $content = str_replace(
            ['SAMPLE RESULT PDF', 'This is a sample PDF for testing.'],
            [strtoupper($schoolName), 'Exam: ' . $examName],
            $this->samplePdfContent
        );

        Storage::disk('public')->put($path, $content);
    }
}
