from PIL import Image
import csv

# Load and resize the black-and-white image
# I place the image in the same folder as the script for simplicity sake
image_path = "logo.jpg"  # Replace with your logo path
# CSV output in the same folder as the script is located
output_csv = "reduced_white_pixel_coordinates.csv"
image = Image.open(image_path).convert("L")  # Convert to grayscale
height = image.height

# Set the interval for sampling (e.g., every 2nd pixel)
# This was due to too many pixel points
sampling_interval = 2  # Adjust this to control the density

# Prepare the CSV file
with open(output_csv, mode="w", newline="") as file:
    writer = csv.writer(file)
    writer.writerow(["X", "Y"])  # Only X and Y coordinates for white pixels because I am using a black and white image

    # Iterate through each pixel with sampling
    for y in range(0, image.height, sampling_interval):
        for x in range(0, image.width, sampling_interval):
            pixel_value = image.getpixel((x, y))
            if pixel_value == 255:  # Only process white pixels
                inverted_y = height - y - 1  # Invert Y coordinate for Grafana, else the image is upside down
                writer.writerow([x, inverted_y])

print(f"CSV with reduced white pixel points saved as {output_csv}")
