CREATE TABLE "recipes" (
   "id" uuid NOT NULL DEFAULT gen_random_uuid(),
   "name" text NOT NULL,
   "ingredients" text NOT NULL,
   "preparation_process" text NOT NULL
);