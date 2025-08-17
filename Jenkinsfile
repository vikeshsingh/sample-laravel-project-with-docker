pipeline {
    agent any

    environment {
        DOCKER_COMPOSE = "docker-compose"
        APP_CONTAINER = "laravel_app"
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/vikeshsingh/sample-laravel-project-with-docker.git'
            }
        }

        stage('Rebuild Containers') {
            steps {
                dir('Automated-Pipeline') {   // 👈 go inside your project folder
                    sh '''
                    ${DOCKER_COMPOSE} down --remove-orphans
                    ${DOCKER_COMPOSE} build --no-cache
                    ${DOCKER_COMPOSE} up -d
                    '''
                }
            }
        }

        stage('Wait for App to be Ready') {
            steps {
                script {
                    echo "⏳ Waiting for Laravel container to be ready..."
                    retry(10) {
                        sleep 5
                        sh "docker exec ${APP_CONTAINER} php -v"
                    }
                }
            }
        }

        stage('Run Post-Deploy Commands') {
            steps {
                dir('Automated-Pipeline') {  // 👈 again inside your project folder
                    sh '''
                    docker exec ${APP_CONTAINER} php artisan cache:clear
                    docker exec ${APP_CONTAINER} php artisan config:cache
                    docker exec ${APP_CONTAINER} php artisan route:cache
                    docker exec ${APP_CONTAINER} php artisan view:clear
                    '''
                }
            }
        }
    }

    post {
        success {
            echo "✅ Deployment completed successfully!"
        }
        failure {
            echo "❌ Deployment failed! Check logs."
        }
    }
}
