/**
 * Global World Academy — Quiz Data
 * Shared across landing page and quiz standalone page.
 * Add new quiz sets by adding a new key to window.quizData.
 */
window.quizData = {
  science: {
    name: 'Science Quiz', icon: '🔬',
    questions: [
      { q: 'Which part of the cell is known as the "powerhouse of the cell"?', opts: ['Nucleus','Ribosome','Mitochondria','Golgi Body'], ans: 2, explain: 'Mitochondria produce ATP through cellular respiration, providing energy — hence called the powerhouse of the cell.' },
      { q: 'What is the chemical formula of water?', opts: ['CO₂','H₂O','O₂','NaCl'], ans: 1, explain: 'Water is H₂O — two hydrogen atoms bonded to one oxygen atom.' },
      { q: 'Which gas do plants absorb during photosynthesis?', opts: ['Oxygen','Nitrogen','Carbon Dioxide','Hydrogen'], ans: 2, explain: 'During photosynthesis, plants absorb CO₂ and water and, using sunlight, convert them into glucose and oxygen.' },
      { q: 'The SI unit of electric current is:', opts: ['Volt','Watt','Ampere','Ohm'], ans: 2, explain: 'The Ampere (A) is the SI base unit of electric current, named after physicist André-Marie Ampère.' },
      { q: 'Which gas is most abundant in Earth\'s atmosphere?', opts: ['Oxygen','Carbon Dioxide','Argon','Nitrogen'], ans: 3, explain: 'Nitrogen (N₂) makes up about 78% of Earth\'s atmosphere.' },
      { q: 'The speed of light in vacuum is approximately:', opts: ['3×10⁶ m/s','3×10⁸ m/s','3×10¹⁰ m/s','3×10⁴ m/s'], ans: 1, explain: 'Speed of light in vacuum = 3×10⁸ m/s (approximately 3 lakh km/s).' },
      { q: 'Which element has the chemical symbol "Au"?', opts: ['Silver','Aluminium','Gold','Argon'], ans: 2, explain: 'Au comes from the Latin word "Aurum" meaning Gold.' },
      { q: 'Newton\'s Second Law of Motion states that Force equals:', opts: ['Mass × Velocity','Mass × Acceleration','Mass / Acceleration','Velocity / Time'], ans: 1, explain: 'F = ma. Newton\'s 2nd Law states Force = Mass × Acceleration.' },
      { q: 'Photosynthesis occurs in which part of a plant cell?', opts: ['Ribosome','Mitochondria','Nucleus','Chloroplast'], ans: 3, explain: 'Photosynthesis takes place in chloroplasts, which contain chlorophyll that captures light energy.' },
      { q: 'Which vitamin is produced when skin is exposed to sunlight?', opts: ['Vitamin A','Vitamin B12','Vitamin C','Vitamin D'], ans: 3, explain: 'Vitamin D is synthesized in the skin when exposed to UVB radiation from sunlight. Essential for calcium absorption.' }
    ]
  },
  child_dev: {
    name: 'Child Development', icon: '👶',
    questions: [
      { q: 'According to Piaget, which stage occurs from birth to 2 years?', opts: ['Pre-operational','Concrete Operational','Sensorimotor','Formal Operational'], ans: 2, explain: 'Piaget\'s Sensorimotor stage (0–2 years) is where children learn through senses and motor activity.' },
      { q: 'Vygotsky\'s "Zone of Proximal Development" (ZPD) refers to:', opts: ['Child\'s current ability','Area between what child can do alone vs with help','IQ level','Memory capacity'], ans: 1, explain: 'ZPD is the gap between what a learner can do independently and with guided assistance from a more capable person.' },
      { q: 'Which is NOT a principle of child development?', opts: ['Development is continuous','Development proceeds from general to specific','Development is reversible','Development follows a pattern'], ans: 2, explain: 'Development is NOT reversible — it follows a fixed, irreversible and predictable sequence.' },
      { q: 'Howard Gardner proposed the theory of:', opts: ['Triarchic Intelligence','Multiple Intelligences','Psychoanalysis','Behaviorism'], ans: 1, explain: 'Howard Gardner proposed the Theory of Multiple Intelligences (1983) — identifying 8 distinct types of intelligence.' },
      { q: 'B.F. Skinner is associated with:', opts: ['Classical Conditioning','Cognitive Development','Operant Conditioning','Humanistic Theory'], ans: 2, explain: 'B.F. Skinner developed Operant Conditioning — behavior is shaped through reinforcement and punishment.' },
      { q: '"Formative Assessment" is best described as:', opts: ['End-of-year exam','Ongoing assessment during learning','Entrance test','Standardized national test'], ans: 1, explain: 'Formative assessment is continuous and happens during teaching to monitor ongoing learning progress.' },
      { q: 'The "Right to Education Act" guarantees free education for children aged:', opts: ['3–14 years','5–18 years','6–14 years','4–16 years'], ans: 2, explain: 'The RTE Act (2009) guarantees free and compulsory education for children aged 6 to 14 years.' },
      { q: 'Which of the following is an example of intrinsic motivation?', opts: ['Cash reward','Medal','Curiosity to learn','Teacher praise'], ans: 2, explain: 'Intrinsic motivation comes from within — curiosity, interest, and personal satisfaction are classic examples.' },
      { q: 'Inclusive education means:', opts: ['Education only for gifted students','All children learn together regardless of abilities','Separate schools for disabled students','Online-only education'], ans: 1, explain: 'Inclusive education integrates all children — with and without disabilities — into mainstream classrooms.' },
      { q: 'Kohlberg\'s Post-conventional level includes which stage?', opts: ['Punishment-Obedience','Social Order','Social Contract','Good Boy-Girl'], ans: 2, explain: 'Social Contract (Stage 5) is under the Post-conventional level of Kohlberg\'s theory of moral development.' }
    ]
  },
  gk: {
    name: 'General Knowledge', icon: '🌍',
    questions: [
      { q: 'Who is the chief architect of the Indian Constitution?', opts: ['Mahatma Gandhi','Jawaharlal Nehru','B.R. Ambedkar','Sardar Patel'], ans: 2, explain: 'Dr. B.R. Ambedkar was chairman of the drafting committee of the Indian Constitution.' },
      { q: 'Which is the longest river in India?', opts: ['Yamuna','Brahmaputra','Ganga','Godavari'], ans: 2, explain: 'The Ganga is the longest river in India at approximately 2,525 km.' },
      { q: 'India\'s National Animal is the:', opts: ['Lion','Elephant','Tiger','Leopard'], ans: 2, explain: 'The Bengal Tiger is India\'s National Animal, adopted in 1973.' },
      { q: 'Which planet is known as the "Red Planet"?', opts: ['Venus','Jupiter','Mars','Saturn'], ans: 2, explain: 'Mars appears red due to iron oxide (rust) on its surface.' },
      { q: 'The Right to Education Act was enacted in India in:', opts: ['2005','2009','2012','2002'], ans: 1, explain: 'The RTE Act was enacted in 2009, making education free and compulsory for children aged 6–14.' },
      { q: 'World Teachers\' Day is celebrated on:', opts: ['October 5','September 5','November 14','January 30'], ans: 0, explain: 'World Teachers\' Day is on October 5 (UNESCO). In India, Teachers\' Day is September 5.' },
      { q: 'Fundamental Rights in India are in which Part of the Constitution?', opts: ['Part II','Part III','Part IV','Part V'], ans: 1, explain: 'Fundamental Rights are in Part III (Articles 12–35) of the Indian Constitution.' },
      { q: 'Which gas is primarily responsible for the Greenhouse Effect?', opts: ['Oxygen','Nitrogen','Carbon Dioxide','Hydrogen'], ans: 2, explain: 'CO₂ is the primary greenhouse gas trapping heat in Earth\'s atmosphere.' },
      { q: 'The 2024 Summer Olympics were held in:', opts: ['Tokyo','London','Paris','Los Angeles'], ans: 2, explain: 'The 2024 Summer Olympics were held in Paris, France (July 26 – August 11, 2024).' },
      { q: 'Which article of the Indian Constitution abolishes untouchability?', opts: ['Article 14','Article 15','Article 17','Article 19'], ans: 2, explain: 'Article 17 abolishes untouchability and forbids its practice in any form.' }
    ]
  },
  mp: {
    name: 'MP GK Quiz', icon: '🗺️',
    questions: [
      { q: 'What is the capital of Madhya Pradesh?', opts: ['Indore','Bhopal','Gwalior','Jabalpur'], ans: 1, explain: 'Bhopal is the state capital of Madhya Pradesh, known as the "City of Lakes".' },
      { q: 'Which river is called the "lifeline of Madhya Pradesh"?', opts: ['Narmada','Tapti','Chambal','Betwa'], ans: 0, explain: 'The Narmada river is called the lifeline of MP — it flows through the heart of the state.' },
      { q: 'Khajuraho temples are in which district of MP?', opts: ['Panna','Chhatarpur','Sagar','Rewa'], ans: 1, explain: 'The Khajuraho Group of Monuments (UNESCO World Heritage Site) is in Chhatarpur district.' },
      { q: 'Which city is the commercial capital of Madhya Pradesh?', opts: ['Bhopal','Gwalior','Ujjain','Indore'], ans: 3, explain: 'Indore is the largest city and commercial hub of Madhya Pradesh.' },
      { q: 'Madhya Pradesh was formed on:', opts: ['November 1, 1956','January 26, 1950','August 15, 1947','November 1, 2000'], ans: 0, explain: 'Madhya Pradesh was formed on November 1, 1956, under the States Reorganisation Act.' },
      { q: 'Kanha National Park in MP is famous for:', opts: ['Elephants','Barasingha (Swamp Deer)','One-Horned Rhino','Snow Leopard'], ans: 1, explain: 'Kanha National Park saved the Barasingha (Swamp Deer) from extinction.' },
      { q: 'Which is the traditional folk dance of Madhya Pradesh?', opts: ['Bharatanatyam','Kathakali','Rai','Garba'], ans: 2, explain: 'Rai is the traditional folk dance of Madhya Pradesh.' },
      { q: 'Why is MP called the "Heart of India"?', opts: ['It has the most rivers','It is geographically at the center','Largest population','Richest state'], ans: 1, explain: 'Madhya Pradesh means "Central Province" and is geographically located at the center of India.' },
      { q: 'Who was the first Chief Minister of Madhya Pradesh?', opts: ['Ravi Shankar Shukla','Shyama Charan Shukla','Arjun Singh','D.P. Mishra'], ans: 0, explain: 'Ravi Shankar Shukla was the first Chief Minister of Madhya Pradesh (1956).' },
      { q: 'Sanchi Stupa (UNESCO World Heritage Site) is in which district of MP?', opts: ['Raisen','Vidisha','Sehore','Bhopal'], ans: 0, explain: 'Sanchi Stupa is located in Raisen district of Madhya Pradesh.' }
    ]
  }
};
