<?php

namespace Database\Seeders;

use App\Models\QuizCategory;
use App\Models\QuizQuestion;
use App\Models\QuizTopic;
use Illuminate\Database\Seeder;

class QuizCategoryTopicSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = $this->subjects();

        QuizCategory::whereNotIn('slug', array_column($subjects, 'slug'))
            ->update(['sort_order' => 1000]);

        foreach ($subjects as $subjectIndex => $subjectData) {
            $topics = $subjectData['topics'];
            unset($subjectData['topics']);

            $category = QuizCategory::updateOrCreate(
                ['slug' => $subjectData['slug']],
                array_merge($subjectData, [
                    'sort_order' => $subjectIndex + 1,
                    'is_active' => true,
                ])
            );

            foreach ($topics as $topicIndex => $topicData) {
                $questions = $topicData['questions'];
                $legacyKey = $topicData['legacy_key'] ?? null;
                unset($topicData['questions'], $topicData['legacy_key']);

                $topic = QuizTopic::updateOrCreate(
                    ['slug' => $topicData['slug']],
                    array_merge($topicData, [
                        'category_id' => $category->id,
                        'sort_order' => $topicIndex + 1,
                        'is_active' => true,
                    ])
                );

                if ($legacyKey) {
                    QuizQuestion::where('topic', $legacyKey)
                        ->whereNull('topic_id')
                        ->update(['topic_id' => $topic->id]);
                }

                $this->seedQuestions($topic, $questions);
            }
        }
    }

    private function seedQuestions(QuizTopic $topic, array $questions): void
    {
        foreach ($questions as $index => $question) {
            QuizQuestion::updateOrCreate(
                [
                    'topic_id' => $topic->id,
                    'question' => $question['question'],
                ],
                array_merge($question, [
                    'topic' => $topic->slug,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ])
            );
        }
    }

    private function q(
        string $question,
        array $options,
        int $answerIndex,
        string $explanation,
        ?string $questionHi = null,
        ?string $explanationHi = null
    ): array {
        return [
            'question' => $question,
            'question_hi' => $questionHi ?? $question,
            'options' => $options,
            'answer_index' => $answerIndex,
            'explanation' => $explanation,
            'explanation_hi' => $explanationHi ?? $explanation,
        ];
    }

    private function subjects(): array
    {
        return [
            [
                'name' => 'Science',
                'name_hi' => 'विज्ञान',
                'slug' => 'science',
                'description' => 'MPTET science practice by topic.',
                'description_hi' => 'विषयवार MPTET विज्ञान अभ्यास।',
                'icon' => '🔬',
                'color' => '#1155cc',
                'topics' => [
                    [
                        'name' => 'General Science',
                        'name_hi' => 'सामान्य विज्ञान',
                        'slug' => 'science-general',
                        'icon' => '⚗️',
                        'legacy_key' => 'science',
                        'questions' => [
                            $this->q('What is the chemical formula of water?', ['CO2', 'H2O', 'O2', 'NaCl'], 1, 'Water contains two hydrogen atoms and one oxygen atom.'),
                            $this->q('Which planet is known as the Red Planet?', ['Venus', 'Jupiter', 'Mars', 'Saturn'], 2, 'Mars appears red because of iron oxide on its surface.'),
                            $this->q('Which gas is most abundant in Earth atmosphere?', ['Oxygen', 'Nitrogen', 'Carbon dioxide', 'Argon'], 1, 'Nitrogen makes up about 78% of Earth atmosphere.'),
                            $this->q('The SI unit of electric current is:', ['Volt', 'Watt', 'Ampere', 'Ohm'], 2, 'Ampere is the SI unit of electric current.'),
                            $this->q('Speed of light in vacuum is approximately:', ['3 x 10^6 m/s', '3 x 10^8 m/s', '3 x 10^10 m/s', '3 x 10^4 m/s'], 1, 'Light travels at about 3 x 10^8 m/s in vacuum.'),
                            $this->q('Which organelle is called the powerhouse of the cell?', ['Nucleus', 'Ribosome', 'Mitochondria', 'Golgi body'], 2, 'Mitochondria produce ATP during cellular respiration.'),
                            $this->q('Au is the chemical symbol of:', ['Silver', 'Aluminium', 'Gold', 'Argon'], 2, 'Au comes from the Latin word Aurum, meaning gold.'),
                            $this->q('The largest gland in the human body is:', ['Pancreas', 'Thyroid', 'Liver', 'Adrenal'], 2, 'The liver is the largest gland in the human body.'),
                            $this->q('Sunlight helps the human body produce which vitamin?', ['Vitamin A', 'Vitamin B12', 'Vitamin C', 'Vitamin D'], 3, 'Skin produces Vitamin D when exposed to sunlight.'),
                            $this->q('DNA stands for:', ['Deoxyribonucleic Acid', 'Diribonucleic Acid', 'Deoxyribonitric Acid', 'Dinitric Acid'], 0, 'DNA is Deoxyribonucleic Acid, the carrier of genetic information.'),
                            $this->q('Sound travels fastest in:', ['Air', 'Water', 'Vacuum', 'Solids'], 3, 'Sound travels fastest in solids because particles are closely packed.'),
                            $this->q('Night blindness is caused by deficiency of:', ['Vitamin B', 'Vitamin C', 'Vitamin A', 'Vitamin K'], 2, 'Vitamin A deficiency can cause night blindness.'),
                            $this->q('The central part of an atom is called:', ['Electron', 'Nucleus', 'Proton', 'Neutron'], 1, 'The nucleus contains protons and neutrons.'),
                            $this->q('An adult human body has how many bones?', ['206', '208', '212', '200'], 0, 'An adult human skeleton has 206 bones.'),
                            $this->q('Best conductor of electricity among these is:', ['Gold', 'Silver', 'Copper', 'Aluminium'], 1, 'Silver has the highest electrical conductivity.'),
                            $this->q('Photosynthesis requires which pigment?', ['Hemoglobin', 'Melanin', 'Chlorophyll', 'Carotene'], 2, 'Chlorophyll captures light energy for photosynthesis.'),
                        ],
                    ],
                    [
                        'name' => 'Biology',
                        'name_hi' => 'जीव विज्ञान',
                        'slug' => 'science-biology',
                        'icon' => '🧬',
                        'questions' => [
                            $this->q('Who discovered the cell?', ['Louis Pasteur', 'Robert Hooke', 'Charles Darwin', 'Gregor Mendel'], 1, 'Robert Hooke observed cells in cork in 1665.'),
                            $this->q('Food is transported in plants through:', ['Xylem', 'Phloem', 'Cortex', 'Epidermis'], 1, 'Phloem transports prepared food from leaves to other parts.'),
                            $this->q('How many chambers are there in the human heart?', ['2', '3', '4', '5'], 2, 'The human heart has four chambers.'),
                        ],
                    ],
                    [
                        'name' => 'Physics',
                        'name_hi' => 'भौतिकी',
                        'slug' => 'science-physics',
                        'icon' => '⚡',
                        'questions' => [
                            $this->q('Newton second law is represented by:', ['F = ma', 'V = IR', 'P = VI', 'E = mc2'], 0, 'Newton second law states force equals mass times acceleration.'),
                            $this->q('The unit of resistance is:', ['Volt', 'Ohm', 'Ampere', 'Joule'], 1, 'Resistance is measured in Ohm.'),
                        ],
                    ],
                ],
            ],
            [
                'name' => 'CDP',
                'name_hi' => 'बाल विकास एवं शिक्षाशास्त्र',
                'slug' => 'cdp',
                'description' => 'Child development and pedagogy practice.',
                'description_hi' => 'बाल विकास और शिक्षाशास्त्र अभ्यास।',
                'icon' => '👶',
                'color' => '#1a8f3c',
                'topics' => [
                    [
                        'name' => 'Child Development & Pedagogy',
                        'name_hi' => 'बाल विकास एवं शिक्षाशास्त्र',
                        'slug' => 'cdp-pedagogy',
                        'icon' => '👶',
                        'legacy_key' => 'child_dev',
                        'questions' => [
                            $this->q('Piaget sensorimotor stage occurs during:', ['0-2 years', '2-7 years', '7-11 years', '11+ years'], 0, 'The sensorimotor stage spans birth to about two years.'),
                            $this->q('Vygotsky ZPD means:', ['Current ability only', 'Learning possible with support', 'Memory capacity', 'IQ score'], 1, 'ZPD is the gap between independent performance and performance with guidance.'),
                            $this->q('Formative assessment is:', ['End exam', 'Ongoing assessment during learning', 'Entrance test', 'Annual exam'], 1, 'Formative assessment happens during teaching and learning.'),
                        ],
                    ],
                ],
            ],
            [
                'name' => 'EVS',
                'name_hi' => 'EVS',
                'slug' => 'evs',
                'description' => 'Environmental studies practice.',
                'description_hi' => 'पर्यावरण अध्ययन अभ्यास।',
                'icon' => '🌿',
                'color' => '#2dba58',
                'topics' => [
                    [
                        'name' => 'Environmental Studies',
                        'name_hi' => 'पर्यावरण अध्ययन',
                        'slug' => 'evs-environmental-studies',
                        'icon' => '🌿',
                        'questions' => [
                            $this->q('Which of these is biodegradable?', ['Plastic bag', 'Glass bottle', 'Vegetable peel', 'Aluminium foil'], 2, 'Vegetable peel decomposes naturally.'),
                            $this->q('The main source of energy for Earth is:', ['Moon', 'Sun', 'Wind', 'Coal'], 1, 'The Sun is Earth primary source of energy.'),
                        ],
                    ],
                ],
            ],
            [
                'name' => 'English',
                'name_hi' => 'अंग्रेजी',
                'slug' => 'english',
                'description' => 'English language practice.',
                'description_hi' => 'अंग्रेजी भाषा अभ्यास।',
                'icon' => '📘',
                'color' => '#2f80ed',
                'topics' => [
                    [
                        'name' => 'Grammar Basics',
                        'name_hi' => 'व्याकरण आधार',
                        'slug' => 'english-grammar-basics',
                        'icon' => '📘',
                        'questions' => [
                            $this->q('Choose the correct article: ___ apple a day keeps the doctor away.', ['A', 'An', 'The', 'No article'], 1, 'Apple begins with a vowel sound, so An is correct.'),
                            $this->q('Find the synonym of happy.', ['Sad', 'Joyful', 'Angry', 'Tired'], 1, 'Joyful means happy.'),
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Hindi',
                'name_hi' => 'हिंदी',
                'slug' => 'hindi',
                'description' => 'Hindi language practice.',
                'description_hi' => 'हिंदी भाषा अभ्यास।',
                'icon' => '📕',
                'color' => '#c0311a',
                'topics' => [
                    [
                        'name' => 'Hindi Grammar',
                        'name_hi' => 'हिंदी व्याकरण',
                        'slug' => 'hindi-grammar',
                        'icon' => '📕',
                        'questions' => [
                            $this->q('संज्ञा किसे कहते हैं?', ['नाम बताने वाले शब्द', 'काम बताने वाले शब्द', 'गुण बताने वाले शब्द', 'संबंध बताने वाले शब्द'], 0, 'व्यक्ति, वस्तु, स्थान या भाव के नाम को संज्ञा कहते हैं।'),
                            $this->q('सुंदर शब्द कौन सा पद है?', ['संज्ञा', 'क्रिया', 'विशेषण', 'सर्वनाम'], 2, 'सुंदर गुण बताता है, इसलिए यह विशेषण है।'),
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Maths',
                'name_hi' => 'गणित',
                'slug' => 'maths',
                'description' => 'Mathematics practice.',
                'description_hi' => 'गणित अभ्यास।',
                'icon' => '🔢',
                'color' => '#6b3fa0',
                'topics' => [
                    [
                        'name' => 'Number System',
                        'name_hi' => 'संख्या पद्धति',
                        'slug' => 'maths-number-system',
                        'icon' => '🔢',
                        'questions' => [
                            $this->q('What is the place value of 5 in 3521?', ['5', '50', '500', '5000'], 2, 'In 3521, 5 is in the hundreds place.'),
                            $this->q('LCM of 4 and 6 is:', ['8', '10', '12', '24'], 2, 'Multiples of 4 and 6 first meet at 12.'),
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Sanskrit',
                'name_hi' => 'संस्कृत',
                'slug' => 'sanskrit',
                'description' => 'Sanskrit language practice.',
                'description_hi' => 'संस्कृत भाषा अभ्यास।',
                'icon' => '📜',
                'color' => '#e8a020',
                'topics' => [
                    [
                        'name' => 'Sanskrit Grammar',
                        'name_hi' => 'संस्कृत व्याकरण',
                        'slug' => 'sanskrit-grammar',
                        'icon' => '📜',
                        'questions' => [
                            $this->q('रामः पठति में कर्ता कौन है?', ['रामः', 'पठति', 'दोनों', 'कोई नहीं'], 0, 'रामः कार्य करने वाला है, इसलिए कर्ता है।'),
                            $this->q('गच्छति किस लकार का रूप है?', ['लट्', 'लङ्', 'लृट्', 'लोट्'], 0, 'गच्छति वर्तमान काल का लट् लकार रूप है।'),
                        ],
                    ],
                ],
            ],
        ];
    }
}
