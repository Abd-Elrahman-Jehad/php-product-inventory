The biggest Docker problem: "I initially struggled with the Dockerfile extension being saved as .txt, which prevented Docker from recognizing it. I solved this by using VS Code to properly rename the file and remove the hidden extension".

The most important Git lesson: "I learned how to organize a professional repository structure by separating the source code into a src/ folder and using .dockerignore to keep the image clean".


During the deployment of this project, several challenges were encountered while working with Git, Docker, and GitHub Codespaces.

One of the main challenges was configuring Docker correctly and ensuring that the container ports were mapped properly. At first, the application did not open in the browser because the port was already in use. This issue was solved by stopping the running container and re-running it using the correct port mapping.

Another challenge was understanding how GitHub Codespaces handles port forwarding. The application did not open automatically at first, but after checking the PORTS tab and using the forwarded URL, the project became accessible through the browser.

There were also some difficulties related to Docker commands and container management, such as rebuilding the image and restarting containers. These issues were resolved by rebuilding the Docker image and running the container again in detached mode.

Overall, these challenges helped improve my understanding of Docker, container networking, and deploying applications using GitHub Codespaces.
