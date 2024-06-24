import json;
import sys;
from deepface import DeepFace;

result = DeepFace.represent(
    img_path = "{{img_path}}",
    model_name = "{{model_name}}",
    enforce_detection = {{enforce_detection}},
    anti_spoofing = "{{anti_spoofing}}",
    detector_backend = "{{detector_backend}}",
    align = {{align}},
    normalization = "{{normalization}}"
);

print(json.dumps(result, default=str))
