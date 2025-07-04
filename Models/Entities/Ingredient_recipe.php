<?php
class IngredientRecipe
{
    private int $id;
    private int $recipeId;
    private int $ingredientId;
    private float $quantity;
    private int $unit_measure_id;

    public function __construct(int $recipeId, int $ingredientId, float $quantity, int $unit_measure_id)
    {
        $this->recipeId = $recipeId;
        $this->ingredientId = $ingredientId;
        $this->quantity = $quantity;
        $this->unit_measure_id = $unit_measure_id;
    }


    public function getId(): int
    {
        return $this->id;
    }
    public function getRecipeId(): int
    {
        return $this->recipeId;
    }
    public function getIngredientId(): int
    {
        return $this->ingredientId;
    }
    public function getQuantity(): float
    {
        return $this->quantity;
    }
    public function getUnitMeasureId(): int
    {
        return $this->unit_measure_id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setRecipeId(int $recipeId): void
    {
        $this->recipeId = $recipeId;
    }
    public function setIngredientId(int $ingredientId): void
    {
        $this->ingredientId = $ingredientId;
    }
    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }
    public function setUnitMeasureId(string $unit_measure_id): void
    {
        $this->unit_measure_id = $unit_measure_id;
    }
}
