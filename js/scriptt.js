// Load header and footer
async function loadLayout() {
    const headerPlaceholder = document.getElementById('header-placeholder');
    const footerPlaceholder = document.getElementById('footer-placeholder');

    if (headerPlaceholder) {
        try {
            const headerResponse = await fetch('layout/header.php');
            if (!headerResponse.ok) {
                throw new Error('Failed to load header');
            }
            const headerHtml = await headerResponse.text();
            headerPlaceholder.innerHTML = headerHtml;
        } catch (error) {
            console.error('Error loading header:', error);
            // Fallback: create basic header if fetch fails
            headerPlaceholder.innerHTML = `
                <header>
                    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
                        <div class="container-fluid px-3">
                            <div class="d-flex align-items-center">
                                <a href="index.php" class="d-flex align-items-center text-decoration-none">
                                    <img src="logo/ung.png" alt="Logo UNG" class="me-2" style="height: 45px; width: auto;">
                                    <img src="logo/spenduGo.png" alt="Logo SpenduGo" style="height: 45px; width: auto;">
                                </a>
                            </div>
                            <div class="mx-auto text-center d-none d-lg-block">
                                <h1 class="h4 mb-0 fw-bold" style="background: linear-gradient(45deg, #11998e, #38ef7d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Berpikir Komputasional</h1>
                                <p class="small text-muted mb-0">Media Pembelajaran Interaktif</p>
                            </div>
                            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item mb-2 mb-lg-0">
                                        <span class="nav-link text-dark fw-semibold">Halo, User</span>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php">Beranda</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="materi.php">Materi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="dekomposisi.php">Dekomposisi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pola.php">Pola</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="abstraksi.php">Abstraksi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="algoritma.php">Algoritma</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="quiz.php">Quiz</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="about.php">Tentang</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </header>
            `;
        }
    }

    if (footerPlaceholder) {
        try {
            const footerResponse = await fetch('layout/footer.php');
            if (!footerResponse.ok) {
                throw new Error('Failed to load footer');
            }
            const footerHtml = await footerResponse.text();
            footerPlaceholder.innerHTML = footerHtml;
        } catch (error) {
            console.error('Error loading footer:', error);
            // Fallback: create basic footer if fetch fails
            footerPlaceholder.innerHTML = `
                <footer class="bg-dark text-light mt-auto">
                    <div class="container py-5">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <h5 class="mb-3">Tentang Kami</h5>
                                <p class="mb-0">Media pembelajaran interaktif untuk memahami konsep berpikir komputasional melalui materi yang menarik dan latihan praktis.</p>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <h5 class="mb-3">Navigasi Cepat</h5>
                                <ul class="list-unstyled">
                                    <li><a href="index.php" class="text-light text-decoration-none">Beranda</a></li>
                                    <li><a href="materi.php" class="text-light text-decoration-none">Materi</a></li>
                                    <li><a href="quiz.php" class="text-light text-decoration-none">Quiz</a></li>
                                    <li><a href="about.php" class="text-light text-decoration-none">Tentang</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <h5 class="mb-3">Topik Utama</h5>
                                <ul class="list-unstyled">
                                    <li><a href="dekomposisi.php" class="text-light text-decoration-none">Dekomposisi</a></li>
                                    <li><a href="pola.php" class="text-light text-decoration-none">Pola</a></li>
                                    <li><a href="abstraksi.php" class="text-light text-decoration-none">Abstraksi</a></li>
                                    <li><a href="algoritma.php" class="text-light text-decoration-none">Algoritma</a></li>
                                </ul>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="mb-0">&copy; 2025 Berpikir Komputasional. All rights reserved.</p>
                        </div>
                    </div>
                </footer>
            `;
        }
    }
}

// Sound Effects
const soundBenar = new Audio('effeckSound/benar.mp3');
const soundSalah = new Audio('effeckSound/salah.mp3');

// Drag and Drop functionality for Dekomposisi
document.addEventListener('DOMContentLoaded', function() {
    // Dekomposisi Drag & Drop
    const dragItems = document.querySelectorAll('.drag-item');
    const dropZone = document.getElementById('drop-zone');
    const checkOrderBtn = document.getElementById('check-order');
    const feedback = document.getElementById('feedback');

    if (dragItems.length > 0 && dropZone) {
        dragItems.forEach(item => {
            item.addEventListener('dragstart', dragStart);
        });

        dropZone.addEventListener('dragover', dragOver);
        dropZone.addEventListener('drop', drop);

        if (checkOrderBtn) {
            checkOrderBtn.addEventListener('click', checkOrder);
        }
    }

    function dragStart(e) {
        e.dataTransfer.setData('text/plain', e.target.textContent);
    }

    function dragOver(e) {
        e.preventDefault();
    }

    function drop(e) {
        e.preventDefault();
        const data = e.dataTransfer.getData('text/plain');
        const draggedItem = Array.from(document.querySelectorAll('.drag-item')).find(item => item.textContent.trim() === data);
        if (draggedItem) {
            dropZone.appendChild(draggedItem);
        }
    }

    function checkOrder() {
        const items = dropZone.querySelectorAll('.drag-item');
        const correctOrder = ['Ambil roti', 'Oleskan selai', 'Tambahkan selada', 'Tutup dengan roti atas'];
        const userOrder = Array.from(items).map(item => item.textContent);

        if (JSON.stringify(userOrder) === JSON.stringify(correctOrder)) {
            feedback.textContent = 'Benar! Urutan langkah membuat sandwich sudah tepat.';
            feedback.style.color = 'green';
            soundBenar.play();
        } else {
            feedback.textContent = 'Urutan belum tepat. Coba lagi!';
            feedback.style.color = 'red';
            soundSalah.play();
        }
    }

    // Pola Pattern Quiz
    const patternAnswer = document.getElementById('pattern-answer');
    const checkPatternBtn = document.getElementById('check-pattern');
    const patternFeedback = document.getElementById('pattern-feedback');

    if (checkPatternBtn) {
        checkPatternBtn.addEventListener('click', function() {
            const answer = parseInt(patternAnswer.value);
            if (answer === 9) {
                patternFeedback.textContent = 'Benar! Pola bilangan ganjil.';
                patternFeedback.style.color = 'green';
                soundBenar.play();
            } else {
                patternFeedback.textContent = 'Salah. Pola adalah bilangan ganjil.';
                patternFeedback.style.color = 'red';
                soundSalah.play();
            }
        });
    }

    // Pola Interactive Demo Buttons
    const patternBtns = document.querySelectorAll('.pattern-btn');
    const patternDisplay = document.getElementById('pattern-display');

    if (patternBtns.length > 0 && patternDisplay) {
        patternBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                if (type === 'arithmetic') {
                    patternDisplay.innerHTML = '<p>Deret Aritmatika: 2, 4, 6, 8, 10, ...</p><p>Setiap suku selanjutnya diperoleh dengan menambahkan bilangan tetap (beda) ke suku sebelumnya.</p>';
                } else if (type === 'geometric') {
                    patternDisplay.innerHTML = '<p>Deret Geometri: 2, 4, 8, 16, 32, ...</p><p>Setiap suku selanjutnya diperoleh dengan mengalikan suku sebelumnya dengan bilangan tetap (rasio).</p>';
                } else if (type === 'fibonacci') {
                    patternDisplay.innerHTML = '<p>Deret Fibonacci: 1, 1, 2, 3, 5, 8, 13, ...</p><p>Setiap suku selanjutnya adalah jumlah dari dua suku sebelumnya.</p>';
                }
            });
        });
    }

    // Fibonacci Demo
    const generateFibBtn = document.getElementById('generate-fib');
    const fibSequence = document.getElementById('fib-sequence');

    if (generateFibBtn && fibSequence) {
        generateFibBtn.addEventListener('click', function() {
            const n = parseInt(document.getElementById('fib-n').value);
            if (n > 0 && n <= 20) {
                let fib = [1, 1];
                for (let i = 2; i < n; i++) {
                    fib.push(fib[i-1] + fib[i-2]);
                }
                fibSequence.textContent = fib.slice(0, n).join(', ');
            } else {
                fibSequence.textContent = 'Masukkan angka antara 1-20';
            }
        });
    }

    // Dekomposisi Divide and Conquer Demo
    const divideBtn = document.getElementById('divide-btn');
    const sortBtn = document.getElementById('sort-btn');
    const dividedArrays = document.getElementById('divided-arrays');
    const sortedResult = document.getElementById('sorted-result');

    if (divideBtn && sortBtn) {
        divideBtn.addEventListener('click', function() {
            const originalArray = [8, 3, 1, 7, 4, 2, 9, 5, 6];
            const mid = Math.floor(originalArray.length / 2);
            const left = originalArray.slice(0, mid);
            const right = originalArray.slice(mid);
            dividedArrays.innerHTML = `<p>Bagian Kiri: [${left.join(', ')}]</p><p>Bagian Kanan: [${right.join(', ')}]</p>`;
            sortBtn.style.display = 'inline-block';
        });

        sortBtn.addEventListener('click', function() {
            const left = [8, 3, 1, 7];
            const right = [4, 2, 9, 5, 6];
            const sortedLeft = left.sort((a, b) => a - b);
            const sortedRight = right.sort((a, b) => a - b);
            sortedResult.innerHTML = `<p>Bagian Kiri Terurut: [${sortedLeft.join(', ')}]</p><p>Bagian Kanan Terurut: [${sortedRight.join(', ')}]</p><p>Gabung dan urutkan: [${[...sortedLeft, ...sortedRight].sort((a, b) => a - b).join(', ')}]</p>`;
        });
    }

    // Abstraksi Search Demo
    const linearSearchBtn = document.getElementById('linear-search');
    const binarySearchBtn = document.getElementById('binary-search');
    const searchResult = document.getElementById('search-result');

    if (linearSearchBtn && binarySearchBtn && searchResult) {
        linearSearchBtn.addEventListener('click', function() {
            const array = document.getElementById('search-array').value.split(',').map(Number);
            const target = parseInt(document.getElementById('search-target').value);
            let found = false;
            let index = -1;
            for (let i = 0; i < array.length; i++) {
                if (array[i] === target) {
                    found = true;
                    index = i;
                    break;
                }
            }
            searchResult.textContent = found ? `Ditemukan di indeks ${index}` : 'Tidak ditemukan';
        });

        binarySearchBtn.addEventListener('click', function() {
            const array = document.getElementById('search-array').value.split(',').map(Number).sort((a, b) => a - b);
            const target = parseInt(document.getElementById('search-target').value);
            let left = 0;
            let right = array.length - 1;
            let found = false;
            let index = -1;
            while (left <= right) {
                const mid = Math.floor((left + right) / 2);
                if (array[mid] === target) {
                    found = true;
                    index = mid;
                    break;
                } else if (array[mid] < target) {
                    left = mid + 1;
                } else {
                    right = mid - 1;
                }
            }
            searchResult.textContent = found ? `Ditemukan di indeks ${index} (array terurut: [${array.join(', ')}])` : 'Tidak ditemukan';
        });
    }

    // Algoritma Types Demo
    const algoBtns = document.querySelectorAll('.algo-btn');
    const algorithmExplanation = document.getElementById('algorithm-explanation');

    if (algoBtns.length > 0 && algorithmExplanation) {
        algoBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                if (type === 'brute') {
                    algorithmExplanation.innerHTML = '<p><strong>Brute Force:</strong> Mencoba semua kemungkinan solusi. Contoh: Mencoba semua kombinasi password.</p>';
                } else if (type === 'greedy') {
                    algorithmExplanation.innerHTML = '<p><strong>Greedy:</strong> Memilih solusi optimal lokal pada setiap langkah. Contoh: Algoritma untuk memberikan kembalian dengan jumlah koin minimal.</p>';
                } else if (type === 'divide') {
                    algorithmExplanation.innerHTML = '<p><strong>Divide & Conquer:</strong> Pecah masalah menjadi submasalah yang lebih kecil, selesaikan secara rekursif, lalu gabungkan. Contoh: Quicksort atau Mergesort.</p>';
                }
            });
        });
    }

    // Algoritma Complexity Demo
    const showComplexityBtn = document.getElementById('show-complexity');
    const complexityChart = document.getElementById('complexity-chart');

    if (showComplexityBtn && complexityChart) {
        showComplexityBtn.addEventListener('click', function() {
            const selected = document.getElementById('complexity-select').value;
            if (selected === 'O(1)') {
                complexityChart.innerHTML = '<p>Konstan: Waktu eksekusi tidak bergantung pada ukuran input. Contoh: Akses array berdasarkan indeks.</p>';
            } else if (selected === 'O(log n)') {
                complexityChart.innerHTML = '<p>Logaritmik: Waktu berkurang drastis saat input bertambah. Contoh: Binary search.</p>';
            } else if (selected === 'O(n)') {
                complexityChart.innerHTML = '<p>Linear: Waktu eksekusi sebanding dengan ukuran input. Contoh: Linear search.</p>';
            } else if (selected === 'O(n log n)') {
                complexityChart.innerHTML = '<p>Linearithmic: Kombinasi linear dan logaritmik. Contoh: Sorting algorithms seperti quicksort.</p>';
            } else if (selected === 'O(n^2)') {
                complexityChart.innerHTML = '<p>Kuadratik: Waktu eksekusi berbanding kuadrat dengan input. Contoh: Bubble sort.</p>';
            }
        });
    }

    // Abstraksi Activity
    const checkAbstractionBtn = document.getElementById('check-abstraction');
    const abstractionFeedback = document.getElementById('abstraction-feedback');

    if (checkAbstractionBtn) {
        checkAbstractionBtn.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.abstraction-activity input[type="checkbox"]:checked');
            const selected = Array.from(checkboxes).map(cb => cb.value);
            const correct = ['ibu kota', 'pulau Jawa'];

            if (selected.length === correct.length && selected.every(val => correct.includes(val))) {
                abstractionFeedback.textContent = 'Benar! Informasi penting untuk peta adalah ibu kota dan lokasi pulau.';
                abstractionFeedback.style.color = 'green';
                soundBenar.play();
            } else {
                abstractionFeedback.textContent = 'Belum tepat. Fokus pada informasi lokasi dan status kota.';
                abstractionFeedback.style.color = 'red';
                soundSalah.play();
            }
        });
    }

    // AI Prediction Demo
    const predictBtn = document.getElementById('predict');
    const predictionResult = document.getElementById('prediction-result');

    if (predictBtn && predictionResult) {
        predictBtn.addEventListener('click', function() {
            const x = parseFloat(document.getElementById('input-x').value);
            if (!isNaN(x)) {
                // Simple linear prediction: y = 2x + 1
                const y = 2 * x + 1;
                predictionResult.textContent = `Prediksi Y: ${y}`;
                predictionResult.style.color = 'green';
                soundBenar.play();
            } else {
                predictionResult.textContent = 'Masukkan nilai X yang valid.';
                predictionResult.style.color = 'red';
                soundSalah.play();
            }
        });
    }

    // Algoritma Flowchart
    const flowchartSteps = document.querySelectorAll('.step');
    const flowchartCanvas = document.getElementById('flowchart-canvas');
    const checkFlowchartBtn = document.getElementById('check-flowchart');
    const flowchartFeedback = document.getElementById('flowchart-feedback');

    if (flowchartSteps.length > 0 && flowchartCanvas) {
        flowchartSteps.forEach(step => {
            step.addEventListener('dragstart', dragStart);
        });

        flowchartCanvas.addEventListener('dragover', dragOver);
        flowchartCanvas.addEventListener('drop', dropFlowchart);

        if (checkFlowchartBtn) {
            checkFlowchartBtn.addEventListener('click', checkFlowchart);
        }
    }

    function dropFlowchart(e) {
        e.preventDefault();
        const data = e.dataTransfer.getData('text/plain');
        const draggedStep = Array.from(document.querySelectorAll('.step')).find(step => step.textContent.trim() === data);
        if (draggedStep) {
            flowchartCanvas.appendChild(draggedStep);
        }
    }

    function checkFlowchart() {
        const steps = flowchartCanvas.querySelectorAll('.step');
        const correctOrder = ['Mulai', 'Input angka', 'Bandingkan', 'Output maksimum', 'Selesai'];
        const userOrder = Array.from(steps).map(step => step.textContent);

        if (JSON.stringify(userOrder) === JSON.stringify(correctOrder)) {
            flowchartFeedback.textContent = 'Benar! Flowchart algoritma mencari nilai maksimum sudah tepat.';
            flowchartFeedback.style.color = 'green';
            soundBenar.play();
        } else {
            flowchartFeedback.textContent = 'Urutan belum tepat. Urutkan dari mulai hingga selesai.';
            flowchartFeedback.style.color = 'red';
            soundSalah.play();
        }
    }

    // Quiz functionality - One question at a time with timer
    let currentQuestionIndex = parseInt(localStorage.getItem('quizCurrentQuestionIndex')) || 0;
    let score = parseInt(localStorage.getItem('quizScore')) || 0;
    let quizCompleted = localStorage.getItem('quizCompleted') === 'true';
    let quizSaved = localStorage.getItem('quizSaved') === 'true';
    let timerInterval;
    let timeLeft = 10;
    let checkAnswerListenerAdded = false;

    // Shuffle function
    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    // Load questions from database
    async function loadQuestions() {
        try {
            const response = await fetch('get_quiz_questions.php');
            const data = await response.json();

            if (data.success) {
                questions = data.questions.map(q => ({
                    id: q.id,
                    question: q.question,
                    type: q.type,
                    options: q.options || [],
                    correct: q.correct_answer // This will be used for checking answers
                }));
                console.log('Questions loaded from database:', questions.length);
            } else {
                console.error('Failed to load questions:', data.message);
                questions = [];
            }
        } catch (error) {
            console.error('Error loading questions:', error);
            questions = [];
        }
    }

    let questions = []; // Questions will be loaded from database

    // Load questions at the start
    loadQuestions();

    // Shuffle the questions order will be done when starting the quiz

    const questionDisplay = document.getElementById('question-display');
    const feedbackDiv = document.getElementById('feedback');
    const checkAnswerBtn = document.getElementById('check-answer');
    const resultsDiv = document.getElementById('results');
    const scoreP = document.getElementById('score');
    const feedbackP = document.getElementById('feedback');
    const retryBtn = document.getElementById('retry-quiz');

    if (retryBtn) {
        retryBtn.addEventListener('click', function() {
            // Reset quiz state
            localStorage.removeItem('quizCurrentQuestionIndex');
            localStorage.removeItem('quizScore');
            localStorage.removeItem('quizCompleted');
            // Show start button and hide results
            const startQuizBtn = document.getElementById('start-quiz');
            if (startQuizBtn) {
                startQuizBtn.style.display = 'block';
            }
            resultsDiv.style.display = 'none';
        });
    }

    async function startQuiz() {
        // Load questions from database first
        await loadQuestions();

        // If no questions loaded, show message
        if (questions.length === 0) {
            const quizMessage = document.getElementById('quiz-message');
            quizMessage.innerHTML = '<p class="alert alert-info">Quiz belum tersedia. Silakan hubungi guru untuk menambahkan soal.</p>';
            quizMessage.style.display = 'block';
            const startQuizBtn = document.getElementById('start-quiz');
            if (startQuizBtn) {
                startQuizBtn.style.display = 'none';
            }
            return;
        }

        // Shuffle questions each time quiz starts
        shuffle(questions);
        currentQuestionIndex = 0;
        score = 0;
        quizCompleted = false;
        localStorage.setItem('quizCompleted', 'false');
        localStorage.setItem('quizCurrentQuestionIndex', '0');
        localStorage.setItem('quizScore', '0');
        resultsDiv.style.display = 'none';
        document.getElementById('quiz-container').style.display = 'block';
        showQuestion(currentQuestionIndex);
    }

    function showQuestion(index) {
        const question = questions[index];
        const progressPercent = ((index + 1) / questions.length) * 100;

        let html = `
            <div class="quiz-progress">
                <div class="progress-text">Pertanyaan ${index + 1} dari ${questions.length}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" style="width: ${progressPercent}%"></div>
                </div>
            </div>
            <h3>${index + 1}. ${question.question}</h3>`;

        if (question.type === 'radio') {
            html += '<div class="options">';
            const shuffledOptions = shuffle([...question.options]);
            shuffledOptions.forEach(option => {
                html += `<label><input type="radio" name="quiz-answer" value="${option.value}"> ${option.text}</label>`;
            });
            html += '</div>';
        }

        questionDisplay.innerHTML = html;
        feedbackDiv.style.display = 'none';
        checkAnswerBtn.style.display = 'block';
        checkAnswerBtn.disabled = false;

        // Add event listener for check answer button if not already added
        if (!checkAnswerListenerAdded) {
            checkAnswerBtn.addEventListener('click', checkAnswer);
            checkAnswerListenerAdded = true;
        }

        // Add event listeners for inputs
        const inputs = questionDisplay.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    checkAnswer();
                }
            });
            input.addEventListener('paste', function(e) {
                e.preventDefault();
            });
        });

        // Start timer
        timeLeft = 45;
        document.getElementById('timer-count').textContent = timeLeft;
        if (timerInterval) clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            timeLeft--;
            document.getElementById('timer-count').textContent = timeLeft;
            if (timeLeft <= 0) {
                checkAnswerBtn.disabled = true;
                clearInterval(timerInterval);
                // Auto-submit with no answer (count as wrong)
                checkAnswer();
            }
        }, 1000);
    }

    function checkAnswer() {
        const question = questions[currentQuestionIndex];
        let isCorrect = false;
        let correctAnswerText = '';

        if (question.type === 'radio') {
            const selected = document.querySelector('input[name="quiz-answer"]:checked');
            if (selected) {
                const selectedLabel = selected.parentElement;
                const selectedText = selectedLabel.textContent.trim();
                isCorrect = selectedText === question.correct[0];
            }
            if (!isCorrect) {
                correctAnswerText = question.correct[0];
            }
        }

        if (isCorrect) {
            score++;
            feedbackDiv.textContent = 'Benar!';
            feedbackDiv.style.color = 'green';
            soundBenar.play();
        } else {
            feedbackDiv.innerHTML = `Salah! Jawaban yang benar adalah: <strong>${correctAnswerText}</strong>`;
            feedbackDiv.style.color = 'red';
            soundSalah.play();
        }

        feedbackDiv.style.display = 'block';
        checkAnswerBtn.style.display = 'none';

        // Save progress to localStorage
        localStorage.setItem('quizCurrentQuestionIndex', currentQuestionIndex);
        localStorage.setItem('quizScore', score);

        // Auto-save progress to server
        saveQuizProgress();

        // Clear timer when moving to next question
        if (timerInterval) clearInterval(timerInterval);

        setTimeout(() => {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                showQuestion(currentQuestionIndex);
            } else {
                showResults();
            }
        }, 1500);
    }

    function showResults(isFinal = true) {
        const percentage = questions.length > 0 ? Math.round((score / questions.length) * 100) : 0;
        scoreP.innerHTML = `<span class="score-display">Skor Anda: ${score}/${questions.length} (${percentage}%)</span>`;

        let feedbackClass = '';
        if (percentage >= 80) {
            feedbackClass = 'feedback-excellent';
            feedbackP.textContent = 'Luar biasa! Anda memahami semua konsep dengan sangat baik. Terus belajar!';
        } else if (percentage >= 60) {
            feedbackClass = 'feedback-good';
            feedbackP.textContent = 'Bagus! Anda memiliki pemahaman yang baik, tapi ada beberapa konsep yang perlu diulang.';
        } else if (percentage >= 40) {
            feedbackClass = 'feedback-average';
            feedbackP.textContent = 'Cukup baik, tapi perlu lebih banyak latihan. Kembali ke materi untuk memperdalam pemahaman.';
        } else {
            feedbackClass = 'feedback-poor';
            feedbackP.textContent = 'Perlu belajar lebih banyak. Silakan ulangi materi dan coba quiz lagi.';
        }
        feedbackP.className = feedbackClass;

        if (isFinal) {
            // Mark quiz as completed
            localStorage.setItem('quizCompleted', 'true');
        }

        document.getElementById('quiz-container').style.display = 'none';
        resultsDiv.style.display = 'block';

        // Hide the Start Quiz button after completion
        const startQuizBtn = document.getElementById('start-quiz');
        if (startQuizBtn) {
            startQuizBtn.style.display = 'none';
        }
    }

    // Save quiz progress function
    async function saveQuizProgress() {
        try {
            const response = await fetch('save_quiz_result.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'progress',
                    question_index: currentQuestionIndex,
                    score: score
                })
            });

            const result = await response.json();
            if (!result.success) {
                console.error('Failed to save progress:', result.message);
            }
        } catch (error) {
            console.error('Error saving quiz progress:', error);
        }
    }

    // Save quiz result function
    async function saveQuizResult() {
        const percentage = questions.length > 0 ? Math.round((score / questions.length) * 100) : 0;
        const saveBtn = document.getElementById('save-result');
        const saveStatus = document.getElementById('save-status');

        saveBtn.disabled = true;
        saveBtn.textContent = 'Menyimpan...';
        saveStatus.style.display = 'block';
        saveStatus.className = 'alert alert-info';
        saveStatus.textContent = 'Menyimpan hasil quiz...';

        try {
            const response = await fetch('save_quiz_result.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'result',
                    score: score,
                    totalQuestions: questions.length,
                    percentage: percentage
                })
            });

            const result = await response.json();

            if (result.success) {
                saveStatus.className = 'alert alert-success';
                saveStatus.textContent = 'Hasil quiz berhasil disimpan!';
                saveBtn.style.display = 'none';
                // Mark quiz as saved and show retry button
                localStorage.setItem('quizSaved', 'true');
                const retryBtn = document.getElementById('retry-quiz');
                if (retryBtn) {
                    retryBtn.style.display = 'block';
                }
            } else {
                saveStatus.className = 'alert alert-danger';
                saveStatus.textContent = 'Gagal menyimpan hasil: ' + result.message;
                saveBtn.disabled = false;
                saveBtn.textContent = 'Simpan Hasil';
            }
        } catch (error) {
            saveStatus.className = 'alert alert-danger';
            saveStatus.textContent = 'Terjadi kesalahan saat menyimpan hasil quiz.';
            saveBtn.disabled = false;
            saveBtn.textContent = 'Simpan Hasil';
            console.error('Error saving quiz result:', error);
        }
    }

    // Add event listener for save result button
    const saveResultBtn = document.getElementById('save-result');
    if (saveResultBtn) {
        saveResultBtn.addEventListener('click', saveQuizResult);
    }

    // Add event listener for start button
    const startQuizBtn = document.getElementById('start-quiz');
    if (startQuizBtn) {
        startQuizBtn.addEventListener('click', function() {
            startQuizBtn.style.display = 'none';
            document.getElementById('quiz-container').style.display = 'block';
            startQuiz();
        });
    }

    // Start quiz or show results if completed, or show current score immediately on refresh/navigation
    if (quizCompleted) {
        showResults();
    } else if (score > 0 || currentQuestionIndex > 0) {
        // Show current score immediately instead of continuing
        showResults(false);
    } else {
        // Show start button
        if (startQuizBtn) startQuizBtn.style.display = 'block';
    }

    // No restart button needed, retry button handles shuffling and restarting

    // Save quiz state before leaving the page
    window.addEventListener('beforeunload', function() {
        localStorage.setItem('quizCurrentQuestionIndex', currentQuestionIndex);
        localStorage.setItem('quizScore', score);
        localStorage.setItem('quizCompleted', quizCompleted);
    });


});

// Initialize hamburger menu after header is loaded
function initializeHamburgerMenu() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    const navBackdrop = document.getElementById('nav-backdrop');

    console.log('Initializing hamburger menu...', { hamburger, navMenu, navBackdrop });

    if (hamburger && navMenu && navBackdrop) {
        // Ensure menu is closed by default
        hamburger.classList.remove('active');
        navMenu.classList.remove('active');
        navBackdrop.classList.remove('active');
        document.body.classList.remove('menu-open');

        // Remove existing event listeners to prevent duplicates
        hamburger.removeEventListener('click', hamburgerClickHandler);
        navBackdrop.removeEventListener('click', backdropClickHandler);
        navMenu.removeEventListener('click', menuClickHandler);

        // Define event handlers
        function hamburgerClickHandler(event) {
            console.log('Hamburger clicked');
            event.preventDefault();
            event.stopPropagation();

            const isActive = hamburger.classList.contains('active');
            console.log('Hamburger clicked, isActive:', isActive);

            if (isActive) {
                // Close menu
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
                navBackdrop.classList.remove('active');
                document.body.classList.remove('menu-open');
                console.log('Menu closed');
            } else {
                // Open menu
                hamburger.classList.add('active');
                navMenu.classList.add('active');
                navBackdrop.classList.add('active');
                document.body.classList.add('menu-open');
                console.log('Menu opened');
            }
        }

        function backdropClickHandler() {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
            navBackdrop.classList.remove('active');
            document.body.classList.remove('menu-open');
            console.log('Menu closed via backdrop');
        }

        function menuClickHandler(event) {
            if (event.target.tagName === 'A') {
                event.preventDefault();
                const href = event.target.getAttribute('href');
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
                navBackdrop.classList.remove('active');
                document.body.classList.remove('menu-open');
                console.log('Menu closed via link click');
                // Navigate after closing menu
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            }
        }

        // Add event listeners
        hamburger.addEventListener('click', hamburgerClickHandler);
        navBackdrop.addEventListener('click', backdropClickHandler);
        navMenu.addEventListener('click', menuClickHandler);

        console.log('Hamburger menu initialized successfully');
    } else {
        console.error('Hamburger menu elements not found:', { hamburger, navMenu, navBackdrop });
    }
}

// Helper function for :contains selector
Element.prototype.matches = Element.prototype.matches || Element.prototype.webkitMatchesSelector || Element.prototype.msMatchesSelector;

function containsText(selector, text) {
    const elements = document.querySelectorAll(selector);
    return Array.from(elements).filter(element => element.textContent.includes(text));
}

document.querySelectorAll = (function(originalQuerySelectorAll) {
    return function(selector) {
        if (selector.includes(':contains')) {
            const [baseSelector, text] = selector.split(':contains');
            return containsText(baseSelector, text.slice(1, -1));
        }
        return originalQuerySelectorAll.call(this, selector);
    };
})(document.querySelectorAll);




// Page transition functionality
function handlePageTransition(event) {
    // Check if it's a navigation link
    if (event.target.tagName === 'A' && event.target.getAttribute('href') &&
        !event.target.getAttribute('href').startsWith('#') &&
        !event.target.getAttribute('href').startsWith('http')) {

        event.preventDefault();
        const targetUrl = event.target.getAttribute('href');

        // Add fade-out class to body
        document.body.classList.add('page-transition', 'fade-out');

        // Navigate after transition
        setTimeout(() => {
            window.location.href = targetUrl;
        }, 400);
    }
}

// Initialize layout on page load
document.addEventListener('DOMContentLoaded', function() {
    loadLayout();

    // Add transition handlers to navigation links
    document.addEventListener('click', handlePageTransition);

    // Add transition class to main content for initial load
    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.classList.add('page-transition', 'fade-in');
    }
});

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const searchResults = document.querySelector('.search-results');

    if (searchInput && searchResults) {
        const topics = [
            { title: 'Dekomposisi', url: 'dekomposisi.php', description: 'Memecah masalah besar menjadi bagian kecil' },
            { title: 'Pola', url: 'pola.php', description: 'Mengenali kemiripan dalam data' },
            { title: 'Abstraksi', url: 'abstraksi.php', description: 'Menyaring informasi penting' },
            { title: 'Algoritma', url: 'algoritma.php', description: 'Urutan langkah-langkah menyelesaikan masalah' },
            { title: 'Quiz', url: 'quiz.php', description: 'Latihan dan evaluasi' }
        ];

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length > 0) {
                const filteredTopics = topics.filter(topic =>
                    topic.title.toLowerCase().includes(query) ||
                    topic.description.toLowerCase().includes(query)
                );
                displaySearchResults(filteredTopics);
            } else {
                searchResults.style.display = 'none';
            }
        });

        function displaySearchResults(results) {
            searchResults.innerHTML = '';
            if (results.length > 0) {
                results.forEach(result => {
                    const item = document.createElement('div');
                    item.className = 'search-result-item';
                    item.innerHTML = `<strong>${result.title}</strong><br>${result.description}`;
                    item.addEventListener('click', function() {
                        window.location.href = result.url;
                    });
                    searchResults.appendChild(item);
                });
                searchResults.style.display = 'block';
            } else {
                searchResults.style.display = 'none';
            }
        }

        // Hide search results when clicking outside
        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                searchResults.style.display = 'none';
            }
        });
    }

    // Scroll animation for topic cards
    const topicCards = document.querySelectorAll('.card');
    if (topicCards.length > 0) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const cardIndex = Array.from(topicCards).indexOf(entry.target);
                    // Add delay based on index for staggered animation
                    setTimeout(() => {
                        if (cardIndex % 2 === 0) {
                            entry.target.classList.add('animate-left');
                        } else {
                            entry.target.classList.add('animate-right');
                        }
                    }, cardIndex * 200); // 200ms delay between each card
                }
            });
        }, observerOptions);

        topicCards.forEach((card, index) => {
            observer.observe(card);

            // Check if card is already in viewport on load (for mobile)
            const rect = card.getBoundingClientRect();
            const isInViewport = rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth);
            if (isInViewport) {
                setTimeout(() => {
                    if (index % 2 === 0) {
                        card.classList.add('animate-left');
                    } else {
                        card.classList.add('animate-right');
                    }
                }, index * 200);
            }
        });
    }
});
