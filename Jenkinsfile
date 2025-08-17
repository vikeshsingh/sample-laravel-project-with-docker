pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                sh 'docker build -t myapp:${BUILD_NUMBER} .'
            }
        }
        stage('Deploy') {
            steps {
                sh 'docker-compose up -d'
            }
        }
        stage('Post-Deployment') {
            steps {
                // Run required Docker commands after successful deployment
                sh '''
                    docker exec -it mycontainer some_command
                    docker logs mycontainer --tail 50
                    docker image prune -f  # Cleanup old images
                '''
            }
        }
    }
}