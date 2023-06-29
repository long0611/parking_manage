import sys
import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3' 


import cv2
from class_CNN import NeuralNetwork
from class_PlateDetection import PlateDetector


########### INIT ###########
# Initialize the plate detector
plateDetector = PlateDetector(type_of_plate='RECT_PLATE',
                                        minPlateArea=4500,
                                        maxPlateArea=30000)

# Initialize the Neural Network
myNetwork = NeuralNetwork(modelFile=r"C:\Users\Hieu\Desktop\QLBDX\laravel_qlbdx\python\model\binary_128_0.50_ver3.pb",
                            labelFile=r"C:\Users\Hieu\Desktop\QLBDX\laravel_qlbdx\python\model\binary_128_0.50_labels_ver2.txt")

img = cv2.imread(sys.argv[1:][0])
possible_plates = plateDetector.find_possible_plates(img)
if possible_plates is not None:
    for i, p in enumerate(possible_plates):
        chars_on_plate = plateDetector.char_on_plate[i]
        recognized_plate, _ = myNetwork.label_image_list(chars_on_plate, imageSizeOuput=128)
        print(recognized_plate)