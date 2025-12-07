<?php

namespace App\Services;

class DecisionTreeService
{
    private $treeStructure;
    private $questions;
    private $diseases;

    public function __construct()
    {
        $this->initializeTreeStructure();
        $this->initializeQuestions();
        $this->initializeDiseases();
    }

    private function initializeTreeStructure()
    {
        $this->treeStructure = [
            'start' => 'Q1',
            
            // Branch untuk nyeri gigi
            'Q1' => [ // Apakah Anda mengalami nyeri gigi?
                'yes' => 'Q2',
                'no' => 'Q6'
            ],
            'Q2' => [ // Apakah nyeri bersifat spontan dan berdenyut?
                'yes' => 'Q3',
                'no' => 'Q9'
            ],
            'Q3' => [ // Apakah nyeri memburuk pada malam hari?
                'yes' => 'D1', // Pulpitis Ireversibel
                'no' => 'Q4'
            ],
            'Q4' => [ // Apakah gigi terasa tinggi saat menggigit?
                'yes' => 'D2', // Abses Periapikal
                'no' => 'Q7'
            ],
            
            // Branch untuk masalah gusi
            'Q6' => [ // Apakah gusi mudah berdarah?
                'yes' => 'Q11',
                'no' => 'Q12'
            ],
            
            // Branch untuk karies
            'Q7' => [ // Apakah ada perubahan warna gigi?
                'yes' => 'Q8',
                'no' => 'Q9'
            ],
            'Q8' => [ // Apakah ada lubang yang terlihat pada gigi?
                'yes' => 'D3', // Karies Dalam
                'no' => 'D4'  // Karies Superfisial
            ],
            'Q9' => [ // Apakah nyeri dipicu oleh makanan/minuman dingin/manis?
                'yes' => 'Q10',
                'no' => 'Q12'
            ],
            'Q10' => [ // Apakah nyeri singkat atau bertahan lama?
                'short' => 'D4', // Karies Superfisial
                'long' => 'D3'   // Karies Dalam
            ],
            
            // Branch untuk bau mulut dan gusi
            'Q11' => [ // Apakah ada bau mulut yang tidak sedap?
                'yes' => 'D5', // Gingivitis
                'no' => 'Q15'
            ],
            
            // Branch untuk luka mulut
            'Q12' => [ // Apakah ada luka di dalam mulut?
                'yes' => 'Q13',
                'no' => 'Q15'
            ],
            'Q13' => [ // Apakah luka berbentuk bulat/oval dengan dasar putih?
                'yes' => 'D6', // Stomatitis Aftosa
                'no' => 'Q14'
            ],
            'Q14' => [ // Apakah ada plak putih yang dapat dikerok?
                'yes' => 'D7', // Kandidiasis Oral
                'no' => 'Q15'
            ],
            
            // Branch untuk masalah periodontal
            'Q15' => [ // Apakah gigi terasa goyang?
                'yes' => 'D8', // Periodontitis
                'no' => 'Q16'
            ],
            'Q16' => [ // Apakah ada resesi gusi?
                'yes' => 'D8', // Periodontitis
                'no' => 'Q17'
            ],
            
            // Branch untuk faktor risiko
            'Q17' => [ // Apakah Anda merokok?
                'yes' => 'D9', // Periodontitis (risiko tinggi)
                'no' => 'Q18'
            ],
            'Q18' => [ // Apakah Anda memiliki kebiasaan menggertakkan gigi?
                'yes' => 'D10', // Bruxism
                'no' => 'D11'   // Tidak dapat didiagnosis
            ]
        ];
    }

    private function initializeQuestions()
    {
        $this->questions = [
            'Q1' => [
                'text' => 'Apakah Anda mengalami nyeri gigi?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q2' => [
                'text' => 'Apakah nyeri bersifat spontan dan berdenyut?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q3' => [
                'text' => 'Apakah nyeri memburuk pada malam hari?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q4' => [
                'text' => 'Apakah gigi terasa tinggi saat menggigit?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q6' => [
                'text' => 'Apakah gusi mudah berdarah?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q7' => [
                'text' => 'Apakah ada perubahan warna gigi?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q8' => [
                'text' => 'Apakah ada lubang yang terlihat pada gigi?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q9' => [
                'text' => 'Apakah nyeri dipicu oleh makanan/minuman dingin/manis?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q10' => [
                'text' => 'Berapa lama nyeri bertahan setelah rangsangan?',
                'type' => 'multiple_choice',
                'options' => [
                    'short' => 'Nyeri singkat (beberapa detik)',
                    'long' => 'Nyeri bertahan lama (beberapa menit atau lebih)'
                ]
            ],
            'Q11' => [
                'text' => 'Apakah ada bau mulut yang tidak sedap?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q12' => [
                'text' => 'Apakah ada luka di dalam mulut?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q13' => [
                'text' => 'Apakah luka berbentuk bulat/oval dengan dasar putih kekuningan dan tepi kemerahan?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q14' => [
                'text' => 'Apakah ada plak putih seperti susu yang dapat dikerok?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q15' => [
                'text' => 'Apakah gigi terasa goyang?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q16' => [
                'text' => 'Apakah ada resesi gusi (gusi turun)?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q17' => [
                'text' => 'Apakah Anda merokok?',
                'type' => 'yes_no',
                'options' => null
            ],
            'Q18' => [
                'text' => 'Apakah Anda memiliki kebiasaan menggertakkan gigi?',
                'type' => 'yes_no',
                'options' => null
            ]
        ];
    }

    private function initializeDiseases()
    {
        $this->diseases = [
            'D1' => 'Pulpitis Ireversibel',
            'D2' => 'Abses Periapikal',
            'D3' => 'Karies Dalam',
            'D4' => 'Karies Superfisial',
            'D5' => 'Gingivitis',
            'D6' => 'Stomatitis Aftosa',
            'D7' => 'Kandidiasis Oral',
            'D8' => 'Periodontitis',
            'D9' => 'Periodontitis (Risiko Tinggi)',
            'D10' => 'Bruxism',
            'D11' => 'Tidak Dapat Didiagnosis'
        ];
    }

    public function getNextNode($currentNode, $answer)
    {
        if (!isset($this->treeStructure[$currentNode])) {
            return null;
        }

        if (isset($this->treeStructure[$currentNode][$answer])) {
            return $this->treeStructure[$currentNode][$answer];
        }

        return null;
    }

    public function getQuestion($questionCode)
    {
        return $this->questions[$questionCode] ?? null;
    }

    public function isDiagnosis($node)
    {
        return str_starts_with($node, 'D');
    }

    public function getDiseaseName($diagnosisCode)
    {
        return $this->diseases[$diagnosisCode] ?? 'Penyakit Tidak Dikenal';
    }

    public function diagnose($answers)
    {
        $currentNode = 'start';
        $path = [];
        $diagnosis = null;

        while ($currentNode && !$this->isDiagnosis($currentNode)) {
            $path[] = $currentNode;
            $answer = $answers[$currentNode] ?? null;
            
            if (!$answer) {
                break;
            }

            $currentNode = $this->getNextNode($currentNode, $answer);
        }

        if ($currentNode && $this->isDiagnosis($currentNode)) {
            $diagnosis = [
                'code' => $currentNode,
                'name' => $this->getDiseaseName($currentNode),
                'confidence' => $this->calculateConfidence($answers, $path),
                'path' => $path
            ];
        }

        return $diagnosis ?? [
            'code' => 'D11',
            'name' => 'Tidak Dapat Didiagnosis',
            'confidence' => 0,
            'path' => $path
        ];
    }

    private function calculateConfidence($answers, $path)
    {
        $matched = 0;
        foreach ($path as $question) {
            if (isset($answers[$question])) {
                $matched++;
            }
        }
        
        return $path ? round(($matched / count($path)) * 100, 2) : 0;
    }

    public function getAllQuestions()
    {
        return $this->questions;
    }

    public function getTreeStructure()
    {
        return $this->treeStructure;
    }
}