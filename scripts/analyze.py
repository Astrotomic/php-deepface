import json;
from deepface import DeepFace;

result = DeepFace.analyze(
    img_path = "{{img_path}}",
    actions={{actions}},
    enforce_detection={{enforce_detection}},
    anti_spoofing={{anti_spoofing}},
    detector_backend="{{detector_backend}}",
    align={{align}},
    silent={{silent}},
);
print(json.dumps(result, default=str))