import sys;
import json;
from deepface import DeepFace;

try:
    result = DeepFace.verify(
        img1_path = "{{img1_path}}",
        img2_path = "{{img2_path}}",
        model_name = "{{model_name}}",
        detector_backend = "{{detector_backend}}",
        distance_metric = "{{distance_metric}}",
        enforce_detection = {{enforce_detection}},
        align = {{align}},
        expand_percentage = {{expand_percentage}},
        normalization = "{{normalization}}",
        silent = {{silent}},
        threshold = {{threshold}},
        anti_spoofing = {{anti_spoofing}},
    );

    print(json.dumps(result, default=str))
except ValueError as e:
    print(json.dumps({"error": str(e)}), file=sys.stderr)
