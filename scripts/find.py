from deepface import DeepFace;

result = DeepFace.find(
    img_path = "{{img_path}}",
    db_path = "{{db_path}}",
    model_name = "{{model_name}}",
    distance_metric = "{{distance_metric}}",
    enforce_detection = {{enforce_detection}},
    anti_spoofing={{anti_spoofing}},
    detector_backend = "{{detector_backend}}",
    align = {{align}},
    normalization = "{{normalization}}",
    silent = {{silent}}
);

print(result[0].to_json())
