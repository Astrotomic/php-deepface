import sys;
import json;
from deepface import DeepFace;

try:
    result = DeepFace.find(
        img_path = "{{img_path}}",
        db_path = "{{db_path}}",
        model_name = "{{model_name}}",
        distance_metric = "{{distance_metric}}",
        enforce_detection = {{enforce_detection}},
        detector_backend = "{{detector_backend}}",
        align = {{align}},
        expand_percentage = {{expand_percentage}},
        threshold = {{threshold}},
        normalization = "{{normalization}}",
        silent = {{silent}},
        refresh_database = {{refresh_database}},
        anti_spoofing = {{anti_spoofing}},
        batched = {{batched}},
    );

    print(result[0].to_json())
except ValueError as e:
    print(json.dumps({"error": str(e)}), file=sys.stderr)
