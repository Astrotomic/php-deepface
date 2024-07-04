import json;
from deepface import DeepFace;

result = DeepFace.extract_faces(
    img_path = "{{img_path}}",
    target_size={{target_size}},
    enforce_detection={{enforce_detection}},
    anti_spoofing={{anti_spoofing}},
    detector_backend="{{detector_backend}}",
    align={{align}},
    grayscale={{grayscale}},
);

print(json.dumps(result, default=str))