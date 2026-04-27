<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // ── SCIENCE ────────────────────────────────────────────
            ['topic'=>'science','question'=>'Which part of the cell is known as the "powerhouse of the cell"?','options'=>['Nucleus','Ribosome','Mitochondria','Golgi Body'],'answer_index'=>2,'explanation'=>'Mitochondria produce ATP through cellular respiration, providing energy — hence called the powerhouse of the cell.','sort_order'=>1],
            ['topic'=>'science','question'=>'What is the chemical formula of water?','options'=>['CO₂','H₂O','O₂','NaCl'],'answer_index'=>1,'explanation'=>'Water is H₂O — two hydrogen atoms bonded to one oxygen atom.','sort_order'=>2],
            ['topic'=>'science','question'=>'Which gas do plants absorb during photosynthesis?','options'=>['Oxygen','Nitrogen','Carbon Dioxide','Hydrogen'],'answer_index'=>2,'explanation'=>'During photosynthesis, plants absorb CO₂ and water and, using sunlight, convert them into glucose and oxygen.','sort_order'=>3],
            ['topic'=>'science','question'=>'The SI unit of electric current is:','options'=>['Volt','Watt','Ampere','Ohm'],'answer_index'=>2,'explanation'=>'The Ampere (A) is the SI base unit of electric current, named after physicist André-Marie Ampère.','sort_order'=>4],
            ['topic'=>'science','question'=>'Which gas is most abundant in Earth\'s atmosphere?','options'=>['Oxygen','Carbon Dioxide','Argon','Nitrogen'],'answer_index'=>3,'explanation'=>'Nitrogen (N₂) makes up about 78% of Earth\'s atmosphere.','sort_order'=>5],
            ['topic'=>'science','question'=>'The speed of light in vacuum is approximately:','options'=>['3×10⁶ m/s','3×10⁸ m/s','3×10¹⁰ m/s','3×10⁴ m/s'],'answer_index'=>1,'explanation'=>'Speed of light in vacuum = 3×10⁸ m/s (approximately 3 lakh km/s).','sort_order'=>6],
            ['topic'=>'science','question'=>'Which element has the chemical symbol "Au"?','options'=>['Silver','Aluminium','Gold','Argon'],'answer_index'=>2,'explanation'=>'Au comes from the Latin word "Aurum" meaning Gold.','sort_order'=>7],
            ['topic'=>'science','question'=>'Newton\'s Second Law of Motion states that Force equals:','options'=>['Mass × Velocity','Mass × Acceleration','Mass / Acceleration','Velocity / Time'],'answer_index'=>1,'explanation'=>'F = ma. Newton\'s 2nd Law states Force = Mass × Acceleration.','sort_order'=>8],
            ['topic'=>'science','question'=>'Photosynthesis occurs in which part of a plant cell?','options'=>['Ribosome','Mitochondria','Nucleus','Chloroplast'],'answer_index'=>3,'explanation'=>'Photosynthesis takes place in chloroplasts, which contain chlorophyll that captures light energy.','sort_order'=>9],
            ['topic'=>'science','question'=>'Which vitamin is produced when skin is exposed to sunlight?','options'=>['Vitamin A','Vitamin B12','Vitamin C','Vitamin D'],'answer_index'=>3,'explanation'=>'Vitamin D is synthesized in the skin when exposed to UVB radiation from sunlight.','sort_order'=>10],

            // ── CHILD DEVELOPMENT ──────────────────────────────────
            ['topic'=>'child_dev','question'=>'According to Piaget, which stage occurs from birth to 2 years?','options'=>['Pre-operational','Concrete Operational','Sensorimotor','Formal Operational'],'answer_index'=>2,'explanation'=>'Piaget\'s Sensorimotor stage (0–2 years) is where children learn through senses and motor activity.','sort_order'=>1],
            ['topic'=>'child_dev','question'=>'Vygotsky\'s "Zone of Proximal Development" (ZPD) refers to:','options'=>['Child\'s current ability','Area between what child can do alone vs with help','IQ level','Memory capacity'],'answer_index'=>1,'explanation'=>'ZPD is the gap between what a learner can do independently and with guided assistance from a more capable person.','sort_order'=>2],
            ['topic'=>'child_dev','question'=>'Which is NOT a principle of child development?','options'=>['Development is continuous','Development proceeds from general to specific','Development is reversible','Development follows a pattern'],'answer_index'=>2,'explanation'=>'Development is NOT reversible — it follows a fixed, irreversible and predictable sequence.','sort_order'=>3],
            ['topic'=>'child_dev','question'=>'Howard Gardner proposed the theory of:','options'=>['Triarchic Intelligence','Multiple Intelligences','Psychoanalysis','Behaviorism'],'answer_index'=>1,'explanation'=>'Howard Gardner proposed the Theory of Multiple Intelligences (1983) — identifying 8 distinct types of intelligence.','sort_order'=>4],
            ['topic'=>'child_dev','question'=>'B.F. Skinner is associated with:','options'=>['Classical Conditioning','Cognitive Development','Operant Conditioning','Humanistic Theory'],'answer_index'=>2,'explanation'=>'B.F. Skinner developed Operant Conditioning — behavior is shaped through reinforcement and punishment.','sort_order'=>5],
            ['topic'=>'child_dev','question'=>'"Formative Assessment" is best described as:','options'=>['End-of-year exam','Ongoing assessment during learning','Entrance test','Standardized national test'],'answer_index'=>1,'explanation'=>'Formative assessment is continuous and happens during teaching to monitor ongoing learning progress.','sort_order'=>6],
            ['topic'=>'child_dev','question'=>'The "Right to Education Act" guarantees free education for children aged:','options'=>['3–14 years','5–18 years','6–14 years','4–16 years'],'answer_index'=>2,'explanation'=>'The RTE Act (2009) guarantees free and compulsory education for children aged 6 to 14 years.','sort_order'=>7],
            ['topic'=>'child_dev','question'=>'Which of the following is an example of intrinsic motivation?','options'=>['Cash reward','Medal','Curiosity to learn','Teacher praise'],'answer_index'=>2,'explanation'=>'Intrinsic motivation comes from within — curiosity, interest, and personal satisfaction are classic examples.','sort_order'=>8],
            ['topic'=>'child_dev','question'=>'Inclusive education means:','options'=>['Education only for gifted students','All children learn together regardless of abilities','Separate schools for disabled students','Online-only education'],'answer_index'=>1,'explanation'=>'Inclusive education integrates all children — with and without disabilities — into mainstream classrooms.','sort_order'=>9],
            ['topic'=>'child_dev','question'=>'Kohlberg\'s Post-conventional level includes which stage?','options'=>['Punishment-Obedience','Social Order','Social Contract','Good Boy-Girl'],'answer_index'=>2,'explanation'=>'Social Contract (Stage 5) is under the Post-conventional level of Kohlberg\'s theory of moral development.','sort_order'=>10],

            // ── GENERAL KNOWLEDGE ──────────────────────────────────
            ['topic'=>'gk','question'=>'Who is the chief architect of the Indian Constitution?','options'=>['Mahatma Gandhi','Jawaharlal Nehru','B.R. Ambedkar','Sardar Patel'],'answer_index'=>2,'explanation'=>'Dr. B.R. Ambedkar was chairman of the drafting committee of the Indian Constitution.','sort_order'=>1],
            ['topic'=>'gk','question'=>'Which is the longest river in India?','options'=>['Yamuna','Brahmaputra','Ganga','Godavari'],'answer_index'=>2,'explanation'=>'The Ganga is the longest river in India at approximately 2,525 km.','sort_order'=>2],
            ['topic'=>'gk','question'=>'India\'s National Animal is the:','options'=>['Lion','Elephant','Tiger','Leopard'],'answer_index'=>2,'explanation'=>'The Bengal Tiger is India\'s National Animal, adopted in 1973.','sort_order'=>3],
            ['topic'=>'gk','question'=>'Which planet is known as the "Red Planet"?','options'=>['Venus','Jupiter','Mars','Saturn'],'answer_index'=>2,'explanation'=>'Mars appears red due to iron oxide (rust) on its surface.','sort_order'=>4],
            ['topic'=>'gk','question'=>'The Right to Education Act was enacted in India in:','options'=>['2005','2009','2012','2002'],'answer_index'=>1,'explanation'=>'The RTE Act was enacted in 2009, making education free and compulsory for children aged 6–14.','sort_order'=>5],
            ['topic'=>'gk','question'=>'World Teachers\' Day is celebrated on:','options'=>['October 5','September 5','November 14','January 30'],'answer_index'=>0,'explanation'=>'World Teachers\' Day is on October 5 (UNESCO). In India, Teachers\' Day is September 5.','sort_order'=>6],
            ['topic'=>'gk','question'=>'Fundamental Rights in India are in which Part of the Constitution?','options'=>['Part II','Part III','Part IV','Part V'],'answer_index'=>1,'explanation'=>'Fundamental Rights are in Part III (Articles 12–35) of the Indian Constitution.','sort_order'=>7],
            ['topic'=>'gk','question'=>'Which gas is primarily responsible for the Greenhouse Effect?','options'=>['Oxygen','Nitrogen','Carbon Dioxide','Hydrogen'],'answer_index'=>2,'explanation'=>'CO₂ is the primary greenhouse gas trapping heat in Earth\'s atmosphere.','sort_order'=>8],
            ['topic'=>'gk','question'=>'The 2024 Summer Olympics were held in:','options'=>['Tokyo','London','Paris','Los Angeles'],'answer_index'=>2,'explanation'=>'The 2024 Summer Olympics were held in Paris, France (July 26 – August 11, 2024).','sort_order'=>9],
            ['topic'=>'gk','question'=>'Which article of the Indian Constitution abolishes untouchability?','options'=>['Article 14','Article 15','Article 17','Article 19'],'answer_index'=>2,'explanation'=>'Article 17 abolishes untouchability and forbids its practice in any form.','sort_order'=>10],

            // ── MP GK ──────────────────────────────────────────────
            ['topic'=>'mp','question'=>'What is the capital of Madhya Pradesh?','options'=>['Indore','Bhopal','Gwalior','Jabalpur'],'answer_index'=>1,'explanation'=>'Bhopal is the state capital of Madhya Pradesh, known as the "City of Lakes".','sort_order'=>1],
            ['topic'=>'mp','question'=>'Which river is called the "lifeline of Madhya Pradesh"?','options'=>['Narmada','Tapti','Chambal','Betwa'],'answer_index'=>0,'explanation'=>'The Narmada river is called the lifeline of MP — it flows through the heart of the state.','sort_order'=>2],
            ['topic'=>'mp','question'=>'Khajuraho temples are in which district of MP?','options'=>['Panna','Chhatarpur','Sagar','Rewa'],'answer_index'=>1,'explanation'=>'The Khajuraho Group of Monuments (UNESCO World Heritage Site) is in Chhatarpur district.','sort_order'=>3],
            ['topic'=>'mp','question'=>'Which city is the commercial capital of Madhya Pradesh?','options'=>['Bhopal','Gwalior','Ujjain','Indore'],'answer_index'=>3,'explanation'=>'Indore is the largest city and commercial hub of Madhya Pradesh.','sort_order'=>4],
            ['topic'=>'mp','question'=>'Madhya Pradesh was formed on:','options'=>['November 1, 1956','January 26, 1950','August 15, 1947','November 1, 2000'],'answer_index'=>0,'explanation'=>'Madhya Pradesh was formed on November 1, 1956, under the States Reorganisation Act.','sort_order'=>5],
            ['topic'=>'mp','question'=>'Kanha National Park in MP is famous for:','options'=>['Elephants','Barasingha (Swamp Deer)','One-Horned Rhino','Snow Leopard'],'answer_index'=>1,'explanation'=>'Kanha National Park saved the Barasingha (Swamp Deer) from extinction.','sort_order'=>6],
            ['topic'=>'mp','question'=>'Which is the traditional folk dance of Madhya Pradesh?','options'=>['Bharatanatyam','Kathakali','Rai','Garba'],'answer_index'=>2,'explanation'=>'Rai is the traditional folk dance of Madhya Pradesh.','sort_order'=>7],
            ['topic'=>'mp','question'=>'Why is MP called the "Heart of India"?','options'=>['It has the most rivers','It is geographically at the center','Largest population','Richest state'],'answer_index'=>1,'explanation'=>'Madhya Pradesh means "Central Province" and is geographically located at the center of India.','sort_order'=>8],
            ['topic'=>'mp','question'=>'Who was the first Chief Minister of Madhya Pradesh?','options'=>['Ravi Shankar Shukla','Shyama Charan Shukla','Arjun Singh','D.P. Mishra'],'answer_index'=>0,'explanation'=>'Ravi Shankar Shukla was the first Chief Minister of Madhya Pradesh (1956).','sort_order'=>9],
            ['topic'=>'mp','question'=>'Sanchi Stupa (UNESCO World Heritage Site) is in which district of MP?','options'=>['Raisen','Vidisha','Sehore','Bhopal'],'answer_index'=>0,'explanation'=>'Sanchi Stupa is located in Raisen district of Madhya Pradesh.','sort_order'=>10],
        ];

        foreach ($questions as $q) {
            QuizQuestion::firstOrCreate(
                ['topic' => $q['topic'], 'question' => $q['question']],
                $q
            );
        }
    }
}
