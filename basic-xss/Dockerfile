# Use a lightweight Python image
FROM python:3.9

# Set working directory
WORKDIR /app

# Copy all files
COPY . /app

# Install dependencies
RUN pip install flask

# Expose the application port
EXPOSE 5003

# Run the Flask app
CMD ["python", "app.py"]
