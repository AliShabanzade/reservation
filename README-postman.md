# Postman Collection — Reservation API

## Import
1. Open Postman → File → Import → انتخاب `postman/collections/Reservation.postman_collection.v2.1.json`.

## Environment
1. Copy `postman/environments/local.template.postman_environment.json` → `local.postman_environment.json`.
2. پر کن متغیرها:
    - `base_url`: آدرس سرور (مثلاً `http://127.0.0.1:8000`)
    - `auth_token` / `api_key`: مقادیر مناسب را قرار بده.

3. در Postman، Environment جدید را Import کن و آن را انتخاب کن.

## Run a single request
- مثلا `POST /api/v1/reservations` — بدنه JSON را از Postman collection بردار و ارسال کن.

## Run full collection with Newman (locally)
نصب newman:
