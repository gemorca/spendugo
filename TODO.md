# TODO: Quiz Save and Retry Logic Update

## Current Status
- [x] Analyze existing code in quiz.php, js/main.js, save_quiz_result.php
- [x] Understand quiz flow and button display logic

## Tasks
- [ ] Edit quiz.php to hide "Coba Lagi" button by default
- [ ] Edit js/main.js to manage button visibility based on save status
- [ ] Add localStorage tracking for save status
- [ ] Update showResults function to conditionally show buttons
- [ ] Update saveQuizResult function to show retry button after successful save
- [ ] Test the changes by simulating quiz flow

## Notes
- Ensure "Coba Lagi" only appears after saving results
- Maintain current quiz progress and score display on refresh
- Use localStorage to persist save status across page reloads
