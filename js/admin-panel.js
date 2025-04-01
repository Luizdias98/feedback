document.addEventListener('DOMContentLoaded', function() {
    // Função para carregar feedbacks
    function loadFeedbacks() {
        fetch('./php/listar_feedbacks.php')
            .then(response => response.json())
            .then(data => {
                const feedbackList = document.getElementById('feedbackList');
                feedbackList.innerHTML = ''; // Limpar lista antes de carregar

                data.forEach(feedback => {
                    const feedbackItem = document.createElement('div');
                    feedbackItem.className = 'feedback-item';

                    // Exibir avaliação em estrelas
                    const stars = '<i class="fas fa-star"></i>'.repeat(feedback.ease_of_use) +
                                  '<i class="far fa-star"></i>'.repeat(5 - feedback.ease_of_use);

                    feedbackItem.innerHTML = `
                        <div class="feedback-header">
                            <div class="feedback-profile">${feedback.user_profile}</div>
                            <div class="feedback-user-name"><strong>Nome:</strong> ${feedback.user_name}</div> <!-- Exibindo o nome do usuário -->
                            <div class="feedback-date">${feedback.created_at}</div>
                        </div>
                        <div class="feedback-stars">${stars}</div>
                        <p><strong>Problemas:</strong> ${feedback.problem_description || 'Nenhum problema reportado.'}</p>
                        <p><strong>Sugestões:</strong> ${feedback.suggestions || 'Nenhuma sugestão fornecida.'}</p>
                    `;
                    feedbackList.appendChild(feedbackItem);
                });

                // Atualizar estatísticas
                updateStatistics(data);
            })
            .catch(error => console.error('Erro ao carregar feedbacks:', error));
    }

    // Função para atualizar estatísticas
    function updateStatistics(feedbacks) {
        const totalFeedbacks = feedbacks.length;
        const totalRating = feedbacks.reduce((sum, feedback) => sum + feedback.ease_of_use, 0);
        
        // Verifica se há feedbacks antes de calcular a média
        const averageRating = totalFeedbacks > 0 ? (totalRating / totalFeedbacks).toFixed(1) : 0;

        const negativeFeedbacks = feedbacks.filter(feedback => feedback.ease_of_use <= 2).length;

        // Atualiza os valores no painel
        document.getElementById('totalFeedbacks').textContent = totalFeedbacks;
        document.getElementById('averageRating').innerHTML = `${averageRating} <i class="fas fa-star" style="font-size: 18px;"></i>`;
        document.getElementById('negativeFeedbacks').textContent = negativeFeedbacks;

        // Atualizar gráfico de distribuição de avaliações
        updateChart(feedbacks);
    }

    // Função para atualizar o gráfico de distribuição de avaliações
    function updateChart(feedbacks) {
        const ratings = [0, 0, 0, 0, 0]; // Contagem de 1 a 5 estrelas
        feedbacks.forEach(feedback => {
            ratings[feedback.ease_of_use - 1]++;
        });

        const ctx = document.getElementById('ratingsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['1 Estrela', '2 Estrelas', '3 Estrelas', '4 Estrelas', '5 Estrelas'],
                datasets: [{
                    label: 'Distribuição de Avaliações',
                    data: ratings,
                    backgroundColor: 'rgba(42, 93, 60, 0.8)',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Navegação por abas
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            this.classList.add('active');
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', function() {
        fetch('logout.php')
            .then(() => window.location.href = 'index.html')
            .catch(error => console.error('Erro ao fazer logout:', error));
    });

    // Carregar feedbacks ao abrir a página
    loadFeedbacks();
});
