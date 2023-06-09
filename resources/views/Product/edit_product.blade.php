@extends('layouts.admin')
    @section('title_page')
    Edit Product
    @endsection
        @section('body_content')
            <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="form-w3layouts">
                <!-- page start-->
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Add List category
                            </header>

                            <div class="panel-body">


                                <div class="position-center">
                                    @foreach($student as $row)
                                        <form role="form" action="{{URL::to('/update_product/'.$row->id_product)}}" method="post"  >
                                            @csrf
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Name Product</label>
                                                <input type="text" class="form-control" value="{{$row->name_product}}"  id="exampleInputEmail1" name="nameProduct" placeholder="Enter name Product">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Price</label>
                                                <input type="number" class="form-control" id="exampleInputEmail1" value="{{$row->money}}" name="Price" placeholder="Enter name Product">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Product Description</label>
                                                <textarea name="description"  id="" class="form-control" style="resize: none;"  rows="8" >{{$row->content}}</textarea>

                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">category</label>

                                                <select name="category" class="form_control input-sm m-bot15" id="">
                                                    @foreach($list_category as $category)
                                                        @if($category->id==$row->id_category)
                                                            <option selected value="{{$category->id}}">{{$category->name}}</option>
                                                        @else
                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>


                                            </div>



                                            </label>
                                </div>







                                <button type="submit" class="btn btn-info">Add catelogies</button>
                                </form>
                            </div>

                    </div>
        </section>

        </div>
        <section class="panel">
            </form>
            @endforeach

            </div>
            <!-- page end-->
            </div>
        </section>
        <!-- footer -->
        <div class="footer">
            <div class="wthree-copyright">
                <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
            </div>
        </div>
        <!-- / footer -->
    </section>

    <!--main content end-->
</section>
        @endsection
